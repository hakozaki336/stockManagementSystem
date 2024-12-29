<?php

namespace App\UseCases\Product;

use App\Exceptions\DomainValidationException;
use App\Exceptions\ProductHasOrdersException;
use App\Exceptions\ProductHasProductInventoriesException;
use App\Models\Product;

class DestroyAction
{
    public function __invoke(Product $product): void
    {
        try {
            $this->validateDomainRule($product);
        } catch (ProductHasOrdersException $e) {
            throw new DomainValidationException($e->getMessage());
        } catch (ProductHasProductInventoriesException $e) {
            throw new DomainValidationException($e->getMessage());
        }
        $this->validateDomainRule($product);

        $product->delete();
    }

    /**
     * MEMO: これは別クラスに切っても良いかもね
     * 削除のためのドメインルールを検証する
     */
    protected function validateDomainRule(Product $product): void
    {
        if ($product->hasOrders()) {
            throw new ProductHasOrdersException();
        }

        if ($product->hasProductInventories()) {
            throw new ProductHasProductInventoriesException();
        }
    }
}