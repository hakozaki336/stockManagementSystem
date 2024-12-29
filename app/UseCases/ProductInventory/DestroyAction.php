<?php

namespace App\UseCases\ProductInventory;

use App\Exceptions\DomainValidationException;
use App\Exceptions\ProductInventoryHasOrdersException;
use App\Models\ProductInventory;

class DestroyAction
{
    public function __invoke(ProductInventory $productInventory): void
    {
        try {
            $this->validateDomainRule($productInventory);
        } catch (ProductInventoryHasOrdersException $e) {
            throw new DomainValidationException($e->getMessage());
        }

        $productInventory->delete();
    }

    /**
     * MEMO: これは別クラスに切っても良いかもね
     * 削除のためのドメインルールを検証する
     */
    protected function validateDomainRule(ProductInventory $productInventory): void
    {
        if ($productInventory->hasOrder()) {
            // TODO: orderは単体なのでこのエクセプションはちょっと違うかも
            throw new ProductInventoryHasOrdersException();
        }
    }
}