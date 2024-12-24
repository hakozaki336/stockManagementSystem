<?php

namespace App\Services;

use App\Exceptions\ProductInventoryHasOrdersException;
use App\Models\Product;
use App\Models\ProductInventory;
use App\UseCases\StockManagementFactory;
use App\UseCases\StockManagementInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

use function Illuminate\Log\log;

class ProductInventoryService
{
    private StockManagementInterface $stockManagement;
    private Collection $productInventoryList;

    // NOTE: 無理やりコンストラクタにリストをぶち込んでいるが、一部メソッドでは使われていないのでゴミコードになっている
    public function __construct(Product $product)
    {
        $this->stockManagement = StockManagementFactory::create($product->stock_management_type);
        $this->productInventoryList = $this->getProductInventories($product->id);
    }

    /**
     * ページネーションされたProductInventoriesを取得する
     */
    public static function getPaginatedProductInventories(int $perPage, int $product_id): LengthAwarePaginator
    {
        // TODO: リポジトリを使ってみるのも良いかもしれない
        $paginatedProductInventory = ProductInventory::with('product')
            ->where('product_id', $product_id)
            ->paginate($perPage);

        return $paginatedProductInventory;
    }

    /**
     * ProductInventoryを削除する
     * NOTE: 良くないと思うが、staticメソッドにしている
     */
    public static function delete(ProductInventory $productInventory): void
    {
        self::validateDomainRuleForDelete($productInventory);

        $productInventory->delete();
    }

    /**
     * ProductInventoryを作成する
     */
    public static function store(array $productInventoryParam): void
    {
        ProductInventory::create($productInventoryParam);
    }

    /**
     * ProductInventoryを更新する
     * NOTE: 良くないと思うが、staticメソッドにしている
     */
    public static function update(ProductInventory $productInventory, array $productInventoryParam): void
    {
        $productInventory->update($productInventoryParam);
    }

    /**
     * productに紐づく複数のproductInventoryを取得する
     */
    private function getProductInventories(int $product_id): Collection
    {
        return ProductInventory::where('product_id', $product_id)->get();
    }

    /**
     * カウント数だけ,productInventoryを割り当て済みにする
     */
    public function dispatchStock(int $count, int $orderId): void
    {
        $this->stockManagement->dispatchStock($this->productInventoryList, $count , $orderId);
    }

    /**
     * カウント数だけ,productInventoryを非割り当てにする
     */
    public function undispatchStock(int $count, int $orderId): void
    {
        $this->stockManagement->undispatchStock($this->productInventoryList, $count, $orderId);
    }

    /**
     * productに紐づくproductInventoriesを取得する
     */
    public static function getPaginateProductInventoryByProducts(int $product_id): LengthAwarePaginator
    {
        return ProductInventory::where('product_id', $product_id)->paginate();
    }

    /**
     * ordersに紐づくproductInventoriesを取得する
     */
    public static function getPaginateProductInventoryByOrders(int $order_id): LengthAwarePaginator
    {
        return ProductInventory::where('order_id', $order_id)->paginate();
    }

    /**
     * 削除のためのドメインルールを検証する
     */
    private static function validateDomainRuleForDelete(ProductInventory $productInventory): void
    {
        if (self::hasReferenceFromOrders($productInventory)) {
            throw new ProductInventoryHasOrdersException();
        }
    }

    /**
     * ordersから参照があるか
     */
    private static function hasReferenceFromOrders(ProductInventory $productInventory): bool
    {
        return $productInventory->order()->exists();
    }

    /**
     * すべてのProductInventoryを取得する
     */
    public static function getAll(): Collection
    {
        return ProductInventory::all();
    }
}
