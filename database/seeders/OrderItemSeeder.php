<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('order_items')->insert([
            [
                'order_id' => 1,
                'product_id' => 1,
                'quantity' => 1,
                'price' => 18000000,
            ],
            [
                'order_id' => 2,
                'product_id' => 2,
                'quantity' => 1,
                'price' => 46000000,
            ],
        ]);
    }
}
