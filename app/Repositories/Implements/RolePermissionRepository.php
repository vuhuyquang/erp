<?php

namespace App\Repositories\Implements;

use App\Repositories\Interfaces\RolePermissionRepositoryInterface;
use App\Models\RolePermission;

class RolePermissionRepository extends BaseRepository implements RolePermissionRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(RolePermission::class);
        $this->fields = RolePermission::FIELDS;
    }

    public function deleteByRoleId($id): int
    {
        return $this->getModel()::where('role_id', $id)->delete();
    }

    public function countByPermissionId($id): int
    {
        return $this->getModel()::where('permission_id', $id)->count();
    }
}
