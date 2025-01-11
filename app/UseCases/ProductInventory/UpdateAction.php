<?php

namespace App\UseCases\ProductInventory;

use App\Models\ProductInventory;

class UpdateAction
{
    public function __invoke(ProductInventory $productInventory, array $param): bool
    {
        return $this->updateProductInventory($productInventory, $param);
    }

    /**
     * 商品在庫を更新する
     */
    private function updateProductInventory($productInventory, array $param): bool
    {
        return $productInventory->fill($param)->save();
    }
}