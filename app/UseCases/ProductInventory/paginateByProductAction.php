<?php

namespace App\UseCases\ProductInventory;

use App\Models\ProductInventory;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginateByProductAction
{
    public function __invoke(productInventory $productInventory, int $productId, int $perpage): LengthAwarePaginator
    {
        return $productInventory
            ->byProductId($productId)
            ->paginate($perpage);
    }
}