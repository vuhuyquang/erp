<?php

namespace App\Repositories\Interfaces;

interface UserRoleRepositoryInterface extends BaseRepositoryInterface
{
    public function deleteByUserId($id);

    public function countByRoleId($id);
}