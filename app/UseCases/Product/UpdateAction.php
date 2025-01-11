<?php

namespace App\UseCases\Product;

use App\Models\Product;

class UpdateAction
{
    public function __invoke(Product $product, array $param): bool
    {
        return $this->updateProduct($product, $param);
    }

    /**
     * 商品を更新する
     */
    private function updateProduct($product, array $param): bool
    {
        return $product->fill($param)->save();
    }
}