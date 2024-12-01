<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductInventory;
use App\UseCases\FifoStockManagement;
use App\UseCases\LifoStockManagement;
use App\UseCases\StockManagementInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductInventoryService
{
    private StockManagementInterface $stockManagement;
    private Collection $productInventoryList;

    public function __construct(Product $product)
    {
        // NOTE: ハードコードしているのでファクトリーにしたい
        if ($product->stock_management_type === 'FIFO') {
            $this->stockManagement = new FifoStockManagement($product->id);
        } elseif ($product->stock_management_type === 'LIFO') {
            $this->stockManagement = new LifoStockManagement($product->id);
        } else {
            // いいね！例外を投げるのは良い
            throw new \Exception('在庫管理タイプが不正です');
        }
        // TODO: 主キーを読み出すメソッドやが、laravelになかったっけ？
        $this->productInventoryList = $this->loadProductInventories($product->id);
    }
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

    /**
     * productに紐づく複数のproductInventoryを取得する
     */
    private function loadProductInventories(int $product_id): Collection
    {
        return ProductInventory::where('product_id', $product_id)->get();
    }

    /**
     * カウント数だけ,productInventoryを割り当て済みにする
     */
    public function reduceStockList(int $count): void
    {
        $this->stockManagement->reduceStock($this->productInventoryList, $count);
    }
}
