<?php

namespace App\UseCases\ProductInventory;

use App\Models\ProductInventory;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginateByOrderAction
{
    public function __invoke(productInventory $productInventory, int $order_id, int $perpage): LengthAwarePaginator
    {
        //　これはない(usecaseちゃうやん) scopeでやるべき
        return $productInventory
            ->where('order_id', $order_id)
            ->paginate($perpage);
    }
}