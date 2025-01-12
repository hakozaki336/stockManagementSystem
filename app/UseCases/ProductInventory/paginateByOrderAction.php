<?php

namespace App\UseCases\ProductInventory;

use App\Models\ProductInventory;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginateByOrderAction
{
    public function __invoke(productInventory $productInventory, int $orderId, int $perpage): LengthAwarePaginator
    {
        return $productInventory
            ->byOrderId($orderId)
            ->paginate($perpage);
    }
}