<?php

namespace App\UseCases\Product;

use App\Models\Product;

class StoreAction
{
    public function __invoke(Product $product, array $param): Product
    {
        $product->fill($param)->save();

        return $product;
    }
}