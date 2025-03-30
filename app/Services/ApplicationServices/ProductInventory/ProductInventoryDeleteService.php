<?php

namespace App\Services\ApplicationServices\ProductInventory;

use App\Exceptions\DomainValidationException;
use App\Exceptions\ProductInventoryHasOrderException;
use App\Models\ProductInventory;
use App\Repository\ProductInventoryRepository;

class ProductInventoryDeleteService
{
    protected ProductInventoryRepository $productInventoryRepository;

    public function __construct(ProductInventoryRepository $productInventoryRepository)
    {
        $this->productInventoryRepository = $productInventoryRepository;
    }

    public function __invoke(ProductInventory $productInventory): bool
    {
        try {
            $this->validateDomainRule($productInventory);
        } catch (ProductInventoryHasOrderException $e) {
            throw new DomainValidationException($e->getMessage());
        }

        return $this->productInventoryRepository->delete($productInventory);
    }

    /**
     * MEMO: これは別クラスに切っても良いかもね
     * 削除のためのドメインルールを検証する
     */
    protected function validateDomainRule(ProductInventory $productInventory): void
    {
        if ($productInventory->hasOrder()) {
            // TODO: orderは単体なのでこのエクセプションはちょっと違うかも
            throw new ProductInventoryHasOrderException();
        }
    }
}