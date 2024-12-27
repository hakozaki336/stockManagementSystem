<?php

namespace App\UseCases\ProductInventory;

use App\Models\ProductInventory;

class StoreAction
{
    private ProductInventory $productInventory;

    public function __construct(ProductInventory $productInventory)
    {
        $this->productInventory = $productInventory;
    }

    public function __invoke(array $param): ProductInventory
    {
        $this->productInventory->fill($param)->save();

        return $this->productInventory;
    }
}