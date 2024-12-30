<?php

namespace App\UseCases\ProductInventory;

use App\Models\ProductInventory;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginateAction
{
    public function __invoke(ProductInventory $productInventory, int $perpage): LengthAwarePaginator
    {
        return $productInventory->paginate($perpage);
    }
}