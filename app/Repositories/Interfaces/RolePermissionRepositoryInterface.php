<?php

namespace App\Repositories\Interfaces;

interface RolePermissionRepositoryInterface extends BaseRepositoryInterface
{
    public function deleteByRoleId($id);

    public function countByPermissionId($id);
}