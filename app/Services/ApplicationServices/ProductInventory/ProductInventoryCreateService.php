<?php

namespace App\Services\ApplicationServices\ProductInventory;

use App\Models\ProductInventory;
use App\Repository\ProductInventoryRepository;

class ProductInventoryCreateService
{
    protected ProductInventoryRepository $productRepository;

    public function __construct(ProductInventoryRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke(array $param): ProductInventory
    {
        return $this->productRepository->create($param);
    }
}