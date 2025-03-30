<?php

namespace App\Services\ApplicationServices\Order;

use App\Enums\StockManagementType;
use App\Exceptions\DomainValidationException;
use App\Exceptions\StockLogicException;
use App\Models\Order;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\UseCases\ProductInventory\Stock\StockAssignmentFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class OrderDestroyService
{
    protected OrderRepository $orderRepository;
    protected ProductRepository $productRepository;
    protected StockAssignmentFactory $stockAssignmentFactory;

    public function __construct(OrderRepository $orderRepository, ProductRepository $productRepository, StockAssignmentFactory $stockAssignmentFactory)
    {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
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
    protected function getStockManagementType(Order $order): StockManagementType
    {
        return $order->product->stock_management_type;
    }

    /**
     * 商品の在庫リストを取得する
     */
    protected function getProductInventoryList(int $productId): Collection
    {
        return $this->productRepository->find($productId)->productInventories;
    }

    /**
     * 在庫を返却する
     */
    protected function unassignStock(StockManagementType $stockManagementType, $productInventoryList, Order $order): void
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