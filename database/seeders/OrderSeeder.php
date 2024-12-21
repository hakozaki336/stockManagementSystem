<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = [
            [
                'product_id' => 1,
                'company_id' => 1,
                'order_count' => 1,
            ],
            [
                'product_id' => 2,
                'company_id' => 2,
                'order_count' => 1,
            ],
            [
                'product_id' => 3,
                'company_id' => 3,
                'order_count' => 1,
            ],
        ];

        foreach ($orders as $order) {
            Order::create($order);
        }
    }
}
