<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('brands')->insert([
            ['name' => 'Honda', 'country' => 'Nhật Bản'],
            ['name' => 'Yamaha', 'country' => 'Nhật Bản'],
            ['name' => 'Suzuki', 'country' => 'Nhật Bản'],
            ['name' => 'Piaggio', 'country' => 'Ý'],
        ]);
    }
}
