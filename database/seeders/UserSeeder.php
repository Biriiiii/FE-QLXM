<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('123456'),
                'role' => 'admin',
            ],
            [
                'name' => 'Nhan Vien',
                'email' => 'staff@example.com',
                'password' => Hash::make('123456'),
                'role' => 'staff',
            ],
        ]);
    }
}
