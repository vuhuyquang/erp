<?php

namespace App\Repositories\Implements;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(User::class);
        $this->fields = User::FIELDS;
    }
}