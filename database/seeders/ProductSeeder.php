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
                'stock' => 10,
            ],
            [
                'name' => 'Product B',
                'price' => 2000,
                'stock' => 20,
            ],
            [
                'name' => 'Product C',
                'price' => 3000,
                'stock' => 30,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
