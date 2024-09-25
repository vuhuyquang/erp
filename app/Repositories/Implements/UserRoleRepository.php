<?php

namespace App\Repositories\Implements;

use App\Repositories\Interfaces\UserRoleRepositoryInterface;
use App\Models\UserRole;

class UserRoleRepository extends BaseRepository implements UserRoleRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(UserRole::class);
        $this->fields = UserRole::FIELDS;
    }

    public function deleteByUserId($id): int
    {
        return $this->getModel()::where('user_id', $id)->delete();
    }

    public function countByRoleId($id): int
    {
        return $this->getModel()::where('role_id', $id)->count();
    }
}
