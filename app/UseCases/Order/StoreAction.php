<?php

namespace App\UseCases\Order;

use App\Exceptions\DomainValidationException;
use App\Exceptions\OutOfStockException;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductInventory;
use Illuminate\Support\Facades\DB;
use App\UseCases\ProductInventory\Stock\StockAssignmentFactory;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

class StoreAction
{
    private Order $order;
    private Product $product;
    private StockAssignmentFactory $stockAssignmentFactory;

    public function __construct(Order $order, Product $product, StockAssignmentFactory $stockAssignmentFactory)
    {
        $this->order = $order;
        $this->product = $product;
        $this->stockAssignmentFactory = $stockAssignmentFactory;
    }

    public function __invoke(array $param): void
    {
        $stockManagementType = $this->getStockManagementType($param['product_id']);
        $productInventoryList = $this->getProductInventoryList($param['product_id']);

        try {
            DB::transaction(function () use ($stockManagementType, $productInventoryList, $param) {
                $this->createOrder($param);
                $this->assignStock($stockManagementType, $productInventoryList, $param['order_count']);
            });
        } catch (InvalidArgumentException | OutOfStockException $e) {
            throw new DomainValidationException($e->getMessage());
        }
    }

    /**
     * 在庫管理タイプを取得する
     */
    private function getStockManagementType(int $productId): string
    {
        return $this->product->findOrFail($productId)->stock_management_type;
    }

    /**
     * 商品の在庫リストを取得する
     */
    private function getProductInventoryList(int $productId): Collection
    {
        return $this->product->findOrFail($productId)->productInventories;
    }

    /**
     * 注文を作成する
     */
    private function createOrder(array $param): bool
    {
        return $this->order->fill($param)->save();
    }

    /**
     * 在庫を割り当てる
     */
    private function assignStock(string $stockManagementType, $productInventoryList, int $orderCount): void
    {
        $stockAssignment = $this
            ->stockAssignmentFactory
            ->create($stockManagementType);
        
        $stockAssignment
            ->assignStock(
                $productInventoryList,
                $orderCount,
                $this->order->id
            );
    }
}