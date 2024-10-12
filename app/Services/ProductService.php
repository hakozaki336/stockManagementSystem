<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    private Product $product;

    public function __construct(int $id)
    {
        $this->product = Product::findOrFail($id);
    }

    public function create(array $param): void
    {
        Product::create($param);
    }

    public function increaseStock(int $count): void
    {
        $this->product->stock += $count;
        $this->product->save();
    }

    public function decreaseStock(int $count): void
    {
        $this->product->stock -= $count;
        $this->product->save();
    }
}