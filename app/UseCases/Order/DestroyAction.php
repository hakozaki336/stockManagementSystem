<?php

namespace App\UseCases\Order;

use App\Exceptions\DomainValidationException;
use App\Exceptions\OrderHasProductsException;
use App\Exceptions\StockLogicException;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductInventory;
use App\UseCases\ProductInventory\Stock\StockAssignmentFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class DestroyAction
{
    private Product $product;
    private StockAssignmentFactory $stockAssignmentFactory;

    public function __construct(Product $product, StockAssignmentFactory $stockAssignmentFactory)
    {
        $this->product = $product;
        $this->stockAssignmentFactory = $stockAssignmentFactory;
    }

    public function __invoke(Order $order): void
    {
        $stockManagementType = $this->getStockManagementType($order);
        $productInventoryList = $this->getProductInventoryList($order->product_id);

        try {
            DB::transaction(function () use ($stockManagementType, $productInventoryList, $order) {
                $this->unassignStock($stockManagementType, $productInventoryList, $order);
                $order->delete();
            });
        } catch (InvalidArgumentException | StockLogicException $e) {
            throw new DomainValidationException($e->getMessage());
        }
    }

    /**
     * 在庫管理タイプを取得する
     */
    protected function getStockManagementType(Order $order): string
    {
        return $order->product->stock_management_type;
    }

    /**
     * 商品の在庫リストを取得する
     */
    protected function getProductInventoryList(int $productId): Collection
    {
        return $this->product->find($productId)->productInventories;
    }

    /**
     * 在庫を返却する
     */
    protected function unassignStock(string $stockManagementType, $productInventoryList, Order $order): void
    {
        $stockAssignment = $this
            ->stockAssignmentFactory
            ->create($stockManagementType);
        
        $stockAssignment
            ->unassignStock(
                $productInventoryList,
                $order->order_count,
                $order->id
            );
    }
}