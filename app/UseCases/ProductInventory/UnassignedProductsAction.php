<?php

namespace App\UseCases\ProductInventory;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class UnassignedProductsAction
{
    public function __invoke(Product $product): Collection
    {
        return $product
            ->productInventories()
            ->unassigned()
            ->get();
    }
}