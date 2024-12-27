<?php

namespace App\UseCases\Product;

use App\Models\Product;

class UpdateAction
{
    public function __invoke(Product $product, array $param): Product
    {
        $product->fill($param)->save();

        return $product;
    }
}