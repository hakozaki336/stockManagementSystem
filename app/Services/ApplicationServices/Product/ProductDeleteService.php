<?php

namespace App\Services\ApplicationServices\Product;

use App\Exceptions\ProductHasOrdersException;
use App\Exceptions\DomainValidationException;
use App\Exceptions\ProductHasProductInventoriesException;
use App\Models\Product;
use App\Repository\ProductRepository;

class ProductDeleteService
{
    protected ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke(Product $product): bool
    {
        try {
            $this->validateDomainRule($product);
        } catch (ProductHasOrdersException | ProductHasProductInventoriesException $e) {
            throw new DomainValidationException($e->getMessage());
        }
        $this->validateDomainRule($product);

        return $this->productRepository->delete($product);
    }

    /**
     * MEMO: これは別クラスに切っても良いかもね
     * 削除のためのドメインルールを検証する
     */
    protected function validateDomainRule(Product $product): void
    {
        if ($product->hasOrders()) {
            throw new ProductHasOrdersException();
        }

        if ($product->hasProductInventories()) {
            throw new ProductHasProductInventoriesException();
        }
    }
}