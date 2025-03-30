<?php

namespace App\Services\ApplicationServices\ProductInventory;

use App\Repository\ProductInventoryRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductInventoryPaginationService
{
    protected ProductInventoryRepository $productInventoryRepository;

    public function __construct(ProductInventoryRepository $productInventoryRepository)
    {
        $this->productInventoryRepository = $productInventoryRepository;
    }

    public function __invoke(int $perPage): LengthAwarePaginator
    {
        return $this->productInventoryRepository->paginate($perPage);
    }
}