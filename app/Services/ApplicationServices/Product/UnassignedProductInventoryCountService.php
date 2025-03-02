<?php

namespace App\Services\ApplicationServices\Product;

use App\Models\Product;
use App\Repository\ProductRepository;

class UnassignedProductInventoryCountService
{
    protected ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke(Product $product): int
    {
        return $this->productRepository
            ->getUnassignedInventories($product)
            ->count();
    }
}