<?php

namespace App\UseCases\Order;

use App\Exceptions\DomainValidationException;
use App\Exceptions\OutOfStockException;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductInventory;
use Illuminate\Support\Facades\DB;
use App\UseCases\ProductInventory\Stock\StockAssignmentFactory;
use InvalidArgumentException;

class StoreAction
{
    private Order $order;
    private Product $product;
    private ProductInventory $productInventory;
    private StockAssignmentFactory $stockAssignmentFactory;

    public function __construct(Order $order, Product $product, ProductInventory $productInventory, StockAssignmentFactory $stockAssignmentFactory)
    {
        $this->order = $order;
        $this->product = $product;
        $this->productInventory = $productInventory;
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

    private function getStockManagementType(int $productId): string
    {
        return $this->product->findOrFail($productId)->stock_management_type;
    }

    private function getProductInventoryList(int $productId)
    {
        return $this->productInventory->getByProductId($productId);
    }

    private function createOrder(array $param): void
    {
        $this->order->fill($param)->save();
    }

    private function assignStock(string $stockManagementType, $productInventoryList, int $orderCount): void
    {
        $stockAssignment = $this->stockAssignmentFactory->create($stockManagementType);
        $stockAssignment->assignStock($productInventoryList, $orderCount, $this->order->id);
    }
}