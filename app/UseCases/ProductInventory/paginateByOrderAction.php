<?php

namespace App\UseCases\ProductInventory;

use App\Models\ProductInventory;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginateByOrderAction
{
    private ProductInventory $productInventory;

    public function __construct(ProductInventory $productInventory)
    {
        $this->productInventory = $productInventory;
    }

    public function __invoke(int $order_id, int $perpage): LengthAwarePaginator
    {
        return $this->productInventory
            ->where('order_id', $order_id)
            ->paginate($perpage);
    }
}