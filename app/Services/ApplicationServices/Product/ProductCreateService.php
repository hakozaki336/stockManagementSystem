<?php

namespace App\Services\ApplicationServices\Product;

use App\Models\Product;
use App\Repository\ProductRepository;

class ProductCreateService
{
    protected ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke(array $params): Product
    {
        return $this->productRepository->create($params);
    }
}