<?php

namespace App\Services\ApplicationServices\Product;

use App\Models\Product;
use App\Repository\ProductRepository;

class ProductUpdateService
{
    protected ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke(Product $product, array $params): Product
    {
        return $this->productRepository->update($product, $params);
    }
}