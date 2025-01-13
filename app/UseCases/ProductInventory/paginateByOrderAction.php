<?php

namespace App\UseCases\ProductInventory;

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginateByOrderAction
{
    public function __invoke(Order $order, int $perpage): LengthAwarePaginator
    {
        return $order
            ->productInventory()
            ->paginate($perpage);
    }
}