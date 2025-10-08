<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('customers')->insert([
            ['name' => 'Nguyen Van A', 'phone' => '0901234567', 'email' => 'vana@example.com', 'address' => 'Hà Nội'],
            ['name' => 'Tran Thi B', 'phone' => '0912345678', 'email' => 'thib@example.com', 'address' => 'Hồ Chí Minh'],
        ]);
    }
}
