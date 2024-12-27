<?php

namespace App\UseCases\Product;

use App\Models\Product;

class StoreAction
{
    private Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function __invoke(array $param): Product
    {
        $this->product->fill($param)->save();

        return $this->product;
    }
}