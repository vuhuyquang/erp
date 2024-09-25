<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'id' => 1,
                'scope' => 'user.create',
                'description' => 'Thêm người dùng',
                'is_system' => 1
            ],
            [
                'id' => 2,
                'scope' => 'user.update',
                'description' => 'Cập nhật người dùng',
                'is_system' => 1
            ],
            [
                'id' => 3,
                'scope' => 'user.delete',
                'description' => 'Xóa người dùng',
                'is_system' => 1
            ],
            [
                'id' => 4,
                'scope' => 'user.list',
                'description' => 'Danh sách người dùng',
                'is_system' => 1
            ],
            [
                'id' => 5,
                'scope' => 'role.create',
                'description' => 'Thêm vai trò',
                'is_system' => 1
            ],
            [
                'id' => 6,
                'scope' => 'role.update',
                'description' => 'Cập nhật vai trò',
                'is_system' => 1
            ],
            [
                'id' => 7,
                'scope' => 'role.delete',
                'description' => 'Xóa vai trò',
                'is_system' => 1
            ],
            [
                'id' => 8,
                'scope' => 'role.list',
                'description' => 'Danh sách vai trò',
                'is_system' => 1
            ],
            [
                'id' => 9,
                'scope' => 'permission.create',
                'description' => 'Thêm quyền',
                'is_system' => 1
            ],
            [
                'id' => 10,
                'scope' => 'permission.update',
                'description' => 'Cập nhật quyền',
                'is_system' => 1
            ],
            [
                'id' => 11,
                'scope' => 'permission.delete',
                'description' => 'Xóa quyền',
                'is_system' => 1
            ],
            [
                'id' => 12,
                'scope' => 'permission.list',
                'description' => 'Danh sách quyền',
                'is_system' => 1
            ],
        ];

        try {
            Permission::insert($permissions);
        } catch (\Throwable $th) {
        }
    }
}
