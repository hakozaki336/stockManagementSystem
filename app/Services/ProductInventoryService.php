<?php

namespace App\Services;

use App\Models\ProductInventory;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductInventoryService
{
    /**
     * ページネーションされたProductInventoriesを取得する
     */
    public function getPaginatedProductInventories(int $perPage, int $product_id): LengthAwarePaginator
    {
        // TODO: リポジトリを使ってみるのも良いかもしれない
        $paginatedProductInventory = ProductInventory::with('product')
            ->where('product_id', $product_id)
            ->orderBy('dispatched', 'asc')
            ->paginate($perPage);

        return $paginatedProductInventory;
    }

    /**
     * ProductInventoryを削除する
     */
    public function delete(ProductInventory $productInventory): void
    {
        $productInventory->delete();
    }

    /**
     * ProductInventoryを作成する
     */
    public function store(array $productInventoryParam): void
    {
        ProductInventory::create($productInventoryParam);
    }

    /**
     * ProductInventoryを更新する
     */
    public function update(ProductInventory $productInventory, array $productInventoryParam): void
    {
        $productInventory->update($productInventoryParam);
    }
}
