<?php

namespace App\Repositories\Implements;

use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Models\Role;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(Role::class);
        $this->fields = Role::FIELDS;
    }
}
