<?php

namespace App\Services\ApplicationServices\ProductInventory;

use App\Repository\ProductInventoryRepository;
use Illuminate\Database\Eloquent\Collection;

class ProductInventoryListService
{
    protected ProductInventoryRepository $productInventoryRepository;

    public function __construct(ProductInventoryRepository $productInventoryRepository)
    {
        $this->productInventoryRepository = $productInventoryRepository;
    }

    public function __invoke(): Collection
    {
        return $this->productInventoryRepository->all();
    }
}