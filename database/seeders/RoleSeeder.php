<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'id' => 1,
                'name' => 'super.admin',
                'description' => 'Quản trị viên cấp cao',
                'is_system' => 1,
            ],
        ];

        try {
            Role::insert($roles);
        } catch (\Throwable $th) {}
    }
}
