<?php

namespace App\Services;

use App\Models\Permission;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Repositories\Interfaces\RolePermissionRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PermissionService extends BaseService
{
  private $permissionRepository;
  private $rolePermissionRepository;

  public function __construct(PermissionRepositoryInterface $permissionRepository, RolePermissionRepositoryInterface $rolePermissionRepository)
  {
    $this->permissionRepository = $permissionRepository;
    $this->rolePermissionRepository = $rolePermissionRepository;
  }

  public function getAll($page, $search): array
  {
    try {
      $response = $this->permissionRepository->select(['id', 'scope', 'description', 'created_at'], $search, ['scope'], 'id', 'DESC', $page ?? 1, 20, []);
      return $this->transformData(true, "Lấy danh sách quyền thành công.", $response);
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
      $permission = $this->permissionRepository->create($data);
      if (!$permission) {
        throw new \Exception('Thêm mới quyền thất bại.');
      }
      DB::commit();
      return $this->transformData(true, 'Thêm mới quyền thành công.', $permission);
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error($e->getMessage());
      return $this->transformData(false, $e->getMessage(), [], 400);
    }
  }

  public function edit($id): array
  {
    try {
      $permission = $this->permissionRepository->findById($id, ['id', 'scope', 'description']);
      if (!$permission) {
        throw new \Exception('Không tìm thấy quyền.');
      }
      if ($permission->is_system == 1) {
        throw new \Exception('Không thể sửa quyền mặc định.');
      }
      return $this->transformData(true, 'Tìm kiếm quyền thành công.', $permission);
    } catch (\Exception $e) {
      Log::error($e->getMessage());
      return $this->transformData(false, $e->getMessage(), [], 400);
    }
  }

  public function update($data, $id): array
  {
    try {
      DB::beginTransaction();
      $data = request()->except('_token');
      $result = $this->permissionRepository->update($id, $data);
      if (!$result) {
        throw new \Exception('Cập nhật vai trò thất bại.');
      }
      DB::commit();
      return $this->transformData(true, 'Cập nhật vai trò thành công.', []);
    } catch (Exception $e) {
      DB::rollBack();
      Log::error($e->getMessage());
      return $this->transformData(false, $e->getMessage(), [], 400);
    }
  }

  public function delete($id): array
  {
    try {
      DB::beginTransaction();
      $permission = $this->permissionRepository->findById($id, ['id']);
      if (!$permission) {
        throw new \Exception('Không tìm thấy quyền.');
      }
      if ($permission->is_system == 1) {
        throw new \Exception('Không thể xoá quyền mặc định.');
      }
      $countRolePermission = $this->rolePermissionRepository->countByPermissionId($id);
      if ($countRolePermission > 0) {
        throw new \Exception('Không thể xóa. Quyền này đang được sử dụng.');
      }
      $permission->delete();
      DB::commit();
      return $this->transformData(true, 'Xóa quyền thành công.', []);
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error($e->getMessage());
      return $this->transformData(false, $e->getMessage(), [], 400);
    }
  }
}
