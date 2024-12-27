<?php

namespace App\UseCases\ProductInventory;

use App\Models\ProductInventory;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginateAction
{
    private ProductInventory $productInventory;

    public function __construct(ProductInventory $productInventory)
    {
        $this->productInventory = $productInventory;
    }

    public function __invoke(int $perpage): LengthAwarePaginator
    {
        return $this->productInventory->paginate($perpage);
    }
}