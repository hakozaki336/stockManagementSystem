<?php

namespace App\UseCases\ProductInventory;

use App\Models\ProductInventory;

class StoreAction
{
    public function __invoke(productInventory $productInventory, array $param): bool
    {
        return $this->createProductInventory($productInventory, $param);
    }

    /**
     * 商品在庫を作成する
     */
    protected function createProductInventory($productInventory, array $param): bool
    {
        return $productInventory->fill($param)->save();
    }
}