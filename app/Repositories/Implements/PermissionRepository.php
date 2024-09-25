<?php

namespace App\Repositories\Implements;

use App\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Models\Permission;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(Permission::class);
        $this->fields = Permission::FIELDS;
    }
}
