<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'id' => 1,
                'username' => 'quangvh18',
                'fullname' => 'Vũ Huy Quang',
                'email' => 'vuhuyquang2k@gmail.com',
                'password' => bcrypt('1234567'),
                'old_password' => bcrypt('1234567'),
                'status' => 1,
                'avatar' => 'avatar_default.png',
                'is_system' => 1,
            ],
        ];

        try {
            User::insert($users);
        } catch (\Throwable $th) {
        }
    }
}
