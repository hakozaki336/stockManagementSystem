<?php

namespace App\UseCases\ProductInventory;

use App\Exceptions\ProductInventoryHasOrdersException;
use App\Models\ProductInventory;

class DestroyAction
{
    public function __invoke(ProductInventory $productInventory): void
    {
        $this->validateDomainRule($productInventory);

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