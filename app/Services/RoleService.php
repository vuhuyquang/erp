<?php

namespace App\Services;

use App\Models\Role;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Repositories\Interfaces\RolePermissionRepositoryInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\UserRoleRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoleService extends BaseService
{
  private $roleRepository;
  private $permissionRepository;
  private $rolePermissionRepository;
  private $userRoleRepository;

  public function __construct(RoleRepositoryInterface $roleRepository, PermissionRepositoryInterface $permissionRepository, RolePermissionRepositoryInterface $rolePermissionRepository, UserRoleRepositoryInterface $userRoleRepository)
  {
    $this->roleRepository = $roleRepository;
    $this->permissionRepository = $permissionRepository;
    $this->rolePermissionRepository = $rolePermissionRepository;
    $this->userRoleRepository = $userRoleRepository;
  }

  public function getAll($page, $search): array
  {
    try {
      $response = $this->roleRepository->select(['id', 'name', 'description', 'created_at'], $search, ['name', 'description'], 'id', 'DESC', $page ?? 1, 20, []);
      return $this->transformData(true, "Lấy danh sách vai trò thành công.", $response);
    } catch (\Exception $e) {
      Log::error($e->getMessage());
      return $this->transformData(false, $e->getMessage(), [], 400);
    }
  }

  public function create(): array
  {
    try {
      $response = $this->permissionRepository->findAll(['id', 'scope', 'description']);
      return $this->transformData(true, "Lấy danh sách quyền thành công.", $response);
    } catch (\Exception $e) {
      Log::error($e->getMessage());
      return $this->transformData(false, $e->getMessage(), [], 400);
    }
  }

  public function store(): array
  {
    try {
      DB::beginTransaction();
      $data = request()->except('_token');
      $role = $this->roleRepository->create($data);
      if (!$role) {
        throw new \Exception('Thêm mới vai trò thất bại.');
      }
      $role->permissions()->attach($data['permissions']);
      DB::commit();
      return $this->transformData(true, 'Thêm mới vai trò thành công.', $role);
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error($e->getMessage());
      return $this->transformData(false, $e->getMessage(), [], 400);
    }
  }

  public function edit($id): array
  {
    try {
      $role = $this->roleRepository->findById($id, ['id', 'name', 'description']);
      if (!$role) {
        throw new \Exception('Không tồn tại vai trò này');
      }

      $rolePermission = $role->permissions->toArray();
      $rolePermission = array_column($rolePermission, "id");
      $permissions = $this->permissionRepository->findAll(['*']);
      return $this->transformData(true, 'Lấy vai trò thành công.', ['role' => $role, 'rolePermission' => $rolePermission, 'permissions' => $permissions]);
    } catch (\Exception $e) {
      Log::error($e->getMessage());
      return $this->transformData(false, $e->getMessage(), [], 400);
    }
  }

  public function update($data, $id): array
  {
    try {
      DB::beginTransaction();
      $permissions = $data->toArray()['permissions'];
      $data = request()->except('_token', 'permissions');
      $role = $this->roleRepository->findById($id, ['id']);
      if (!$role) {
        throw new \Exception('Không tồn tại vai trò này.');
      }
      $this->roleRepository->update($id, $data);
      $this->rolePermissionRepository->deleteByRoleId($id);
      $role->permissions()->attach($permissions);
      DB::commit();
      return $this->transformData(true, 'Cập nhật vai trò thành công.', []);
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
      $role = $this->roleRepository->findById($id, ['id']);
      if (!$role) {
        throw new \Exception('Không tìm thấy vai trò.');
      }
      $countUserRole = $this->userRoleRepository->countByRoleId($id);
      if ($countUserRole > 0) {
        throw new \Exception('Không thể xóa. Vai trò này đang được sử dụng.');
      }
      $role->permissions()->detach();
      $role->delete();
      DB::commit();
      return $this->transformData(true, 'Xóa vai trò thành công.', []);
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error($e->getMessage());
      return $this->transformData(false, $e->getMessage(), [], 400);
    }
  }
}
