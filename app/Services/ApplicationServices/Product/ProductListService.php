<?php

namespace App\Services\ApplicationServices\Product;

use App\Repository\ProductRepository;
use Illuminate\Database\Eloquent\Collection;

class ProductListService
{
    protected ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke(): Collection
    {
        return $this->productRepository->all();
    }
}