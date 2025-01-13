<?php

namespace App\UseCases\ProductInventory;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginateByProductAction
{
    public function __invoke(Product $product, int $perpage): LengthAwarePaginator
    {
        return $product
            ->productInventories()
            ->with('product')
            ->paginate($perpage);
    }
}