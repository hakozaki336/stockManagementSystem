<?php

namespace App\UseCases\ProductInventory;

use App\Models\ProductInventory;
use Illuminate\Database\Eloquent\Collection;

class IndexAction
{
    private ProductInventory $productInventory;

    public function __construct(ProductInventory $productInventory)
    {
        $this->productInventory = $productInventory;
    }

    public function __invoke(): Collection
    {
        return $this->productInventory->all();
    }
}