<?php

namespace App\Services\ApplicationServices\Product;

use App\Repository\ProductRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductPaginationService
{
    protected ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke(int $perPage): LengthAwarePaginator
    {
        return $this->productRepository->paginate($perPage);
    }
}