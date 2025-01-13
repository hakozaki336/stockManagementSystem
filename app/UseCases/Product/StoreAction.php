<?php

namespace App\UseCases\Product;

use App\Models\Product;

class StoreAction
{
    public function __invoke(Product $product, array $param): bool
    {
        return $this->createProduct($product, $param);
    }

    /**
     * 商品を作成する
     */
    protected function createProduct($product, array $param): bool
    {
        return $product->fill($param)->save();
    }
}