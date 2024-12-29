<?php

namespace App\UseCases\ProductInventory;

use App\Models\ProductInventory;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginateByProductAction
{
    public function __invoke(productInventory $productInventory, int $product_id, int $perpage): LengthAwarePaginator
    {
        return $productInventory
            ->where('product_id', $product_id)
            ->paginate($perpage);
    }
}