<?php

namespace App\UseCases\Product;

use App\Exceptions\ProductHasOrdersException;
use App\Models\Product;

class DestroyAction
{
    public function __invoke(Product $product): void
    {
        $this->validateDomainRule($product);

        $product->delete();
    }

    /**
     * MEMO: これは別クラスに切っても良いかもね
     * 削除のためのドメインルールを検証する
     */
    private function validateDomainRule(Product $product): void
    {
        if ($product->hasOrders()) {
            throw new ProductHasOrdersException();
        }
    }
}