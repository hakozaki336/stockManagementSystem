<?php

namespace App\UseCases\ProductInventory;

use App\Models\ProductInventory;
use Illuminate\Pagination\LengthAwarePaginator;

class paginateByProductAction
{
    private ProductInventory $productInventory;

    public function __construct(ProductInventory $productInventory)
    {
        $this->productInventory = $productInventory;
    }

    public function __invoke(int $product_id, int $perpage): LengthAwarePaginator
    {
        return $this->productInventory
            ->where('product_id', $product_id)
            ->paginate($perpage);
    }
}