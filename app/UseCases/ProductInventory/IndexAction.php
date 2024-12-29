<?php

namespace App\UseCases\ProductInventory;

use App\Models\ProductInventory;
use Illuminate\Database\Eloquent\Collection;

class IndexAction
{
    public function __invoke(ProductInventory $productInventory): Collection
    {
        return $productInventory->all();
    }
}