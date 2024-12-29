<?php

namespace App\UseCases\ProductInventory;

use App\Models\ProductInventory;

class StoreAction
{
    public function __invoke(productInventory $productInventory, array $param): ProductInventory
    {
        $productInventory->fill($param)->save();

        return $productInventory;
    }
}