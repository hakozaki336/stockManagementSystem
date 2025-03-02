<?php

namespace App\Services\ApplicationServices\ProductInventory;

use App\Models\ProductInventory;
use App\Repository\ProductInventoryRepository;

class ProductInventoryUpdateService
{
    protected ProductInventoryRepository $productInventoryRepository;

    public function __construct(ProductInventoryRepository $productInventoryRepository)
    {
        $this->productInventoryRepository = $productInventoryRepository;
    }

    public function __invoke(ProductInventory $productInventory, array $params): ProductInventory
    {
        return $this->productInventoryRepository->update($productInventory, $params);
    }
}