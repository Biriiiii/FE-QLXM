<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('orders')->insert([
            [
                'customer_id' => 1,
                'order_date' => now(),
                'total_amount' => 18000000,
                'status' => 'completed',
            ],
            [
                'customer_id' => 2,
                'order_date' => now(),
                'total_amount' => 46000000,
                'status' => 'pending',
            ],
        ]);
    }
}
