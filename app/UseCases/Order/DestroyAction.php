<?php

namespace App\UseCases\Order;

use App\Exceptions\OrderHasProductsException;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductInventory;
use App\UseCases\ProductInventory\Stock\StockAssignmentFactory;
use Illuminate\Support\Facades\DB;

class DestroyAction
{
    private ProductInventory $productInventory;
    private StockAssignmentFactory $stockAssignmentFactory;

    public function __construct(ProductInventory $productInventory, StockAssignmentFactory $stockAssignmentFactory)
    {
        $this->productInventory = $productInventory;
        $this->stockAssignmentFactory = $stockAssignmentFactory;
    }

    public function __invoke(Order $order): bool
    {
        $stockManagementType = $order->product->stock_management_type;
        $stockAssignment = $this->stockAssignmentFactory->create($stockManagementType);

        $productInventoryList = $this->productInventory->getByProductId($order->product_id);

        DB::transaction(function () use ($stockAssignment, $productInventoryList, $order) {
            $stockAssignment->undispatchStock($productInventoryList, $order->order_count, $order->id);
            $order->delete();
        });

        return true;
    }
}