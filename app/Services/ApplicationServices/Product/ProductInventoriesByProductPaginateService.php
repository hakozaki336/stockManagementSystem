<?php

namespace App\Services\ApplicationServices\Product;

use App\Models\Product;
use App\Repository\ProductRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductInventoriesByProductPaginateService
{
    protected ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke(Product $product, int $perPage): LengthAwarePaginator
    {
        return $this->productRepository->getPaginateByProductInventories($product, $perPage);
    }
}