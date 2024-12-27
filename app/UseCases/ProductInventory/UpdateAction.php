<?php

namespace App\UseCases\ProductInventory;

use App\Models\ProductInventory;

class UpdateAction
{
    public function __invoke(ProductInventory $productInventory, array $param): ProductInventory
    {
        $productInventory->fill($param)->save();

        return $productInventory;
    }
}