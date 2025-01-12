<?php

namespace App\UseCases\ProductInventory;

use App\Models\ProductInventory;
use Illuminate\Database\Eloquent\Collection;

class UnassignedProductsAction
{
    public function __invoke(productInventory $productInventory, int $productId): Collection
    {
        return $productInventory
            ->byProductId($productId)
            ->unAssigned()
            ->get();
    }
}