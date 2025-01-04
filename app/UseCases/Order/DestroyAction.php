<?php

namespace App\UseCases\Order;

use App\Exceptions\DomainValidationException;
use App\Exceptions\OrderHasProductsException;
use App\Exceptions\StockLogicException;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductInventory;
use App\UseCases\ProductInventory\Stock\StockAssignmentFactory;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

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

        $productInventoryList = $this->productInventory->getByProductId($order->product_id);

        try {
            DB::transaction(function () use ($stockManagementType, $productInventoryList, $order) {
                $stockAssignment = $this->stockAssignmentFactory->create($stockManagementType);
                $stockAssignment->unAssignStock($productInventoryList, $order->order_count, $order->id);
                $order->delete();
            });
        } catch (InvalidArgumentException $e) {
            throw new DomainValidationException($e->getMessage());
        } catch (StockLogicException $e) {
            throw new DomainValidationException($e->getMessage());
        }


        return true;
    }
}