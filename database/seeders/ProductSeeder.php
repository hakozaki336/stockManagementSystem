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
            [
                'name' => 'Product D',
                'price' => 4000,
                'area' => 'D',
                'stock_management_type' => 'LIFO',
            ],
            [
                'name' => 'Product E',
                'price' => 5000,
                'area' => 'E',
                'stock_management_type' => 'FIFO',
            ],
            [
                'name' => 'Product F',
                'price' => 6000,
                'area' => 'F',
                'stock_management_type' => 'FIFO',
            ],
            [
                'name' => 'Product G',
                'price' => 7000,
                'area' => 'G',
                'stock_management_type' => 'LIFO',
            ],
            [
                'name' => 'Product H',
                'price' => 8000,
                'area' => 'H',
                'stock_management_type' => 'LIFO',
            ],
            [
                'name' => 'Product I',
                'price' => 9000,
                'area' => 'I',
                'stock_management_type' => 'FIFO',
            ],
            [
                'name' => 'Product J',
                'price' => 10000,
                'area' => 'J',
                'stock_management_type' => 'FIFO',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
