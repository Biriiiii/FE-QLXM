<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Xe số', 'description' => 'Dòng xe số phổ biến, tiết kiệm nhiên liệu'],
            ['name' => 'Xe tay ga', 'description' => 'Dòng xe tay ga tiện lợi, phù hợp thành phố'],
            ['name' => 'Xe côn tay', 'description' => 'Xe thể thao, mạnh mẽ cho giới trẻ'],
        ]);
    }
}
