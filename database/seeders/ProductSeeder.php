<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Honda Wave Alpha',
                'price' => 18000000,
                'description' => 'Xe số tiết kiệm xăng, bền bỉ',
                'brand_id' => 1,
                'category_id' => 1,
                'image' => 'wave_alpha.jpg',
                'stock' => 10,
                'status' => 'available',
            ],
            [
                'name' => 'Yamaha Exciter 155',
                'price' => 46000000,
                'description' => 'Xe côn tay thể thao mạnh mẽ',
                'brand_id' => 2,
                'category_id' => 3,
                'image' => 'exciter155.jpg',
                'stock' => 5,
                'status' => 'available',
            ],
            [
                'name' => 'Honda Vision',
                'price' => 31000000,
                'description' => 'Xe tay ga nhỏ gọn, tiện lợi',
                'brand_id' => 1,
                'category_id' => 2,
                'image' => 'vision.jpg',
                'stock' => 8,
                'status' => 'available',
            ],
        ]);
    }
}
