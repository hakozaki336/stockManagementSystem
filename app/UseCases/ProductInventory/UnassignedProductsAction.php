<?php

namespace App\UseCases\ProductInventory;

use App\Models\ProductInventory;
use Illuminate\Database\Eloquent\Collection;

class UnassignedProductsAction
{
    public function __invoke(productInventory $productInventory, int $product_id): Collection
    {
        return $productInventory
            ->where('product_id', $product_id)
            ->whereNull('order_id')
            ->get();
    }
}