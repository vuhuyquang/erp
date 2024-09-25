<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\UserRoleRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Jobs\SendResetLinkEmailJob;

class UserService extends BaseService
{
  private $userRepository;
  private $roleRepository;
  private $userRoleRepository;

  public function __construct(UserRepositoryInterface $userRepository, RoleRepositoryInterface $roleRepository, UserRoleRepositoryInterface $userRoleRepository)
  {
    $this->userRepository = $userRepository;
    $this->roleRepository = $roleRepository;
    $this->userRoleRepository = $userRoleRepository;
  }

  public function getAll($page, $search): array
  {
    try {
      $response = $this->userRepository->select(['id', 'username', 'fullname', 'email', 'status', 'avatar', 'created_at'], $search, ['username', 'fullname', 'email'], 'id', 'DESC', $page ?? 1, 20, []);
      return $this->transformData(true, "Lấy danh sách người dùng thành công.", $response);
    } catch (\Exception $e) {
      Log::error($e->getMessage());
      return $this->transformData(false, $e->getMessage(), [], 400);
    }
  }

  public function create(): array
  {
    try {
      $response = $this->roleRepository->findAll(['id', 'name', 'description']);
      return $this->transformData(true, "Lấy danh sách vai trò thành công.", $response);
    } catch (\Exception $e) {
      Log::error($e->getMessage());
      return $this->transformData(false, $e->getMessage(), [], 400);
    }
  }

  public function store($data): array
  {
    try {
      DB::beginTransaction();

      $data = request()->except('_token');
      if (isset($data['avatar']) && $data['avatar']->isValid()) {
        $avatar = $data['avatar'];
        $filename = random_int(0, 100) . time() . '.' . 'webp';

        // Resize ảnh và lưu file .webp
        $resizedImage = Image::make($avatar)->fit(100, 100)->encode('webp');
        Storage::put('public/images/' . $filename, (string) $resizedImage);
        $data['avatar'] = $filename;
      } else {
        $data['avatar'] = 'avatar_default.png';
      }

      $data['password'] = bcrypt($data['password']);
      $data['old_password'] = $data['password'];
      $user = $this->userRepository->createFromData($data);
      if (!$user) {
        throw new \Exception('Thêm mới người dùng thất bại.');
      }
      $user->roles()->attach($data['roles']);

      DB::commit();
      return $this->transformData(true, 'Thêm mới người dùng thành công.', $user);
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error($e->getMessage());
      return $this->transformData(false, $e->getMessage(), [], 400);
    }
  }

  public function edit($id): array
  {
    try {
      $user = $this->userRepository->findById($id, ['id', 'username', 'fullname', 'email', 'status']);
      if (!$user) {
        throw new \Exception('Không tìm thấy người dùng.');
      }
      $userRole = $user->roles->toArray();
      $userRole = array_column($userRole, "id");
      $roles = $this->roleRepository->findAll(['id', 'name', 'description']);
      return $this->transformData(true, 'Tìm kiếm người dùng thành công.', ['user' => $user, 'userRole' => $userRole, 'roles' => $roles]);
    } catch (\Exception $e) {
      Log::error($e->getMessage());
      return $this->transformData(false, $e->getMessage(), [], 400);
    }
  }

  public function update($data, $id): array
  {
    try {
      DB::beginTransaction();
      $roles = $data->toArray()['roles'];
      $data = request()->except('_token');
      $hasFile = isset($data['avatar']) && $data['avatar']->isValid();
      if ($hasFile) {
        $avatar = $data['avatar'];
        $filename = random_int(0, 100) . time() . '.' . 'webp';

        Log::info('Resize ảnh và lưu file .webp');
        $resizedImage = Image::make($avatar)->fit(100, 100)->encode('webp');
        Storage::put('public/images/' . $filename, (string) $resizedImage);
        $data['avatar'] = $filename;
      }

      $user = $this->userRepository->findById($id, ['*']);
      if ($user) {
        $path = public_path('storage/images/' . $user->avatar);
      }
      if (!$user) {
        throw new \Exception('Không tồn tại người dùng này.');
      }
      if ($data['password'] == '') {
        unset($data['password']);
      } else {
        Log::info('Kiểm tra mật khẩu mới có trùng với 3 mật khẩu gần nhất không');
        $passwordList = explode(' , ', $this->userRepository->findById($id, ['*'])->old_password);
        foreach ($passwordList as $oldPassword) {
          if (Hash::check($data['password'], $oldPassword)) {
            throw new \Exception('Mật khẩu mới trùng với 3 mật khẩu gần nhất. Hãy thư lại.');
          }
        }

        Log::info('Format lại danh sách mật khẩu cũ');
        $data['password'] = bcrypt($data['password']);
        $passwordList[] = $data['password'];
        if (count($passwordList) >= 4) {
          unset($passwordList[0]);
        }
        $data['old_password'] = implode(' , ', $passwordList);
      }

      unset($data['roles']);
      $result = $this->userRepository->update($id, $data);
      if ($hasFile && $result && file_exists($path)) {
        unlink($path);
      }
      $this->userRoleRepository->deleteByUserId($id);
      $user->roles()->attach($roles);
      if (!$result) {
        throw new \Exception('Cập nhật người dùng thất bại.');
      }
      DB::commit();
      return $this->transformData(true, 'Cập nhật người dùng thành công.', []);
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error($e->getMessage());
      return $this->transformData(false, $e->getMessage(), [], 400);
    }
  }

  public function delete($id): array
  {
    try {
      DB::beginTransaction();
      $user = $this->userRepository->findById($id, ['*']);
      $path = public_path('storage/images/' . $user->avatar);
      if (!$user) {
        throw new \Exception('Không tìm thấy người dùng.');
      }

      Log::info('Xóa người dùng, kiểm tra tồn tại đường dẫn ảnh và xóa file');
      if ($user->roles()->detach() && $user->delete()) {
        if (file_exists($path) && $user->avatar != 'avatar_default.png') {
          unlink($path);
        }
      }
      DB::commit();
      return $this->transformData(true, 'Xóa người dùng thành công.', []);
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error($e->getMessage());
      return $this->transformData(false, $e->getMessage(), [], 400);
    }
  }

  public function login($data): array
  {
    try {
      $rememberMe = $data->toArray()['rememberMe'];
      $data = request()->except('_token', 'rememberMe');
      if (Auth::attempt($data, $rememberMe)) {
        return $this->transformData(true, 'Đăng nhập thành công', null);
      } else {
        throw new \Exception('Tài khoản hoặc mật khẩu không chính xác');
      }
    } catch (\Exception $e) {
      Log::error($e->getMessage());
      return $this->transformData(false, $e->getMessage(), [], 400);
    }
  }

  public function logout(): void
  {
    Auth::logout();
  }

  public function postProfile($data): array
  {
    try {
      DB::beginTransaction();
      $data = request()->except('_token');
      $user = $this->userRepository->update(Auth::user()->id, $data);
      DB::commit();
      return $this->transformData(true, 'Cập nhật thông tin cá nhân thành công', $user);
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error($e->getMessage());
      return $this->transformData(false, $e->getMessage(), [], 400);
    }
  }

  public function changePassword($data): array
  {
    try {
      DB::beginTransaction();
      if (!Hash::check($data->oldPassword, $this->userRepository->findById(Auth::user()->id, ['*'])->password)) {
        throw new \Exception('Mật khẩu hiện tại không chính xác');
      }
      $data = request()->except('_token');

      Log::info('Kiểm tra mật khẩu mới có trùng với 3 mật khẩu gần nhất không');
      $passwordList = explode(' , ', $this->userRepository->findById(Auth::user()->id, ['*'])->old_password);
      foreach ($passwordList as $oldPassword) {
        if (Hash::check($data['password'], $oldPassword)) {
          throw new \Exception('Mật khẩu mới trùng với 3 mật khẩu gần nhất. Hãy thư lại.');
        }
      }

      Log::info('Format lại danh sách mật khẩu cũ');
      $data['password'] = bcrypt($data['password']);
      $passwordList[] = $data['password'];
      if (count($passwordList) >= 4) {
        unset($passwordList[0]);
      }
      $data['old_password'] = implode(' , ', $passwordList);
      unset($data['oldPassword'], $data['reNewPassword']);

      Log::info('Cập nhật mật khẩu mới');
      $user = $this->userRepository->update(Auth::user()->id, $data);
      if (!$user) {
        throw new \Exception('Đổi mật khẩu thất bại');
      }
      DB::commit();
      return $this->transformData(true, 'Đổi mật khẩu thành công', []);
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error($e->getMessage());
      return $this->transformData(false, $e->getMessage(), [], 400);
    }
  }

  public function resetPassword($data): array
  {
    try {
      DB::beginTransaction();
      $data = request()->except('_token');
      $user = $this->userRepository->where(['id', 'fullname', 'old_password'], [['email', '=', $data['email']]])->first()->toArray();
      $newPassword = $this->generateRandomString();
      $oldPassword = $this->transformOldPassword($user['old_password'], $newPassword);

      Log::info('Cập nhật mật khẩu mới và gửi mail sử dụng hàng đợi');
      $this->userRepository->update($user['id'], [
        'password' => bcrypt($newPassword),
        'old_password' => $oldPassword
      ]);
      $data['password'] = $newPassword;
      $data['fullname'] = $user['fullname'];
      // dispatch(new SendResetLinkEmailJob($data));
      DB::commit();
      return $this->transformData(true, 'Đã gửi mail đặt lại mật khẩu', []);
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error($e->getMessage());
      return $this->transformData(false, $e->getMessage(), [], 400);
    }
  }

  private function transformOldPassword($oldPassword, $newPassword): string
  {
    Log::info('Format lại danh sách mật khẩu cũ');
    $passwordList = explode(' , ', $oldPassword);
    $newPassword = bcrypt($newPassword);
    $passwordList[] = $newPassword;
    if (count($passwordList) >= 4) {
      unset($passwordList[0]);
    }

    return implode(' , ', $passwordList);
  }

  private function generateRandomString($length = 12): string
  {
    Log::info('Tạo ngẫu nhiên một mật khẩu mới');
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+';
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    if (!preg_match('/[a-z]/', $randomString) || !preg_match('/[A-Z]/', $randomString) || !preg_match('/[0-9]/', $randomString) || !preg_match('/[!@#$%^&*()-_=+]/', $randomString)) {
      return $this->generateRandomString($length);
    }

    return $randomString;
  }
}
