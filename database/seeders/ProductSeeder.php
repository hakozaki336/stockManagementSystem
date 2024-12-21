<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Product A',
                'price' => 1000,
                'area' => 'A',
                'stock_management_type' => 'FIFO',
            ],
            [
                'name' => 'Product B',
                'price' => 2000,
                'area' => 'B',
                'stock_management_type' => 'FIFO',
            ],
            [
                'name' => 'Product C',
                'price' => 3000,
                'area' => 'C',
                'stock_management_type' => 'LIFO',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
