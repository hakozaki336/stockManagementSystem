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
    // MEMO: この引数の多さは何か。。技術的な敗北を感じる
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

    public function __invoke(array $param): Order
    {
        $stockManagementType = $this->product->findOrFail($param['product_id'])->stock_management_type;

        $productInventoryList = $this->productInventory->getByProductId($param['product_id']);

        try {
            DB::transaction(function () use ($stockManagementType, $productInventoryList, $param) {
                $this->order->fill($param)->save();
                $stockAssignment = $this->stockAssignmentFactory->create($stockManagementType);
                $stockAssignment->dispatchStock($productInventoryList, $param['order_count'], $this->order->id);
            });
        } catch (InvalidArgumentException $e) {
            throw new DomainValidationException($e->getMessage());
        } catch (OutOfStockException $e) {
            throw new DomainValidationException($e->getMessage());
        }


        return new Order();
    }
}