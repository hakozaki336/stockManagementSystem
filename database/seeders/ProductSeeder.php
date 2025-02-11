<?php

namespace Database\Seeders;

use App\Models\Product;
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
                'area' => 0,
                'stock_management_type' => 0, // FIFO
            ],
            [
                'name' => 'Product B',
                'price' => 2000,
                'area' => 0,
                'stock_management_type' => 0, // FIFO
            ],
            [
                'name' => 'Product C',
                'price' => 3000,
                'area' => 0,
                'stock_management_type' => 1, // LIFO
            ],
            [
                'name' => 'Product D',
                'price' => 4000,
                'area' => 0,
                'stock_management_type' => 1, // LIFO
            ],
            [
                'name' => 'Product E',
                'price' => 5000,
                'area' => 1,
                'stock_management_type' => 0, // FIFO
            ],
            [
                'name' => 'Product F',
                'price' => 6000,
                'area' => 1,
                'stock_management_type' => 0, // FIFO
            ],
            [
                'name' => 'Product G',
                'price' => 7000,
                'area' => 1,
                'stock_management_type' => 1, // LIFO
            ],
            [
                'name' => 'Product H',
                'price' => 8000,
                'area' => 2,
                'stock_management_type' => 1, // LIFO
            ],
            [
                'name' => 'Product I',
                'price' => 9000,
                'area' => 2,
                'stock_management_type' => 0, // FIFO
            ],
            [
                'name' => 'Product J',
                'price' => 10000,
                'area' => 2,
                'stock_management_type' => 0, // FIFO
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}