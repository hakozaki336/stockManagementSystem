<?php

namespace App\Services\ApplicationServices\Order;

use App\Enums\StockManagementType;
use App\Exceptions\DomainValidationException;
use App\Exceptions\OutOfStockException;
use App\Models\Order;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Services\DomainServices\Stock\StockAssignmentFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class OrderCreateService
{
    protected OrderRepository $orderRepository;
    protected ProductRepository $productRepository;
    protected StockAssignmentFactory $StockAssignmentFactory;

    public function __construct(OrderRepository $orderRepository, ProductRepository $productRepository, StockAssignmentFactory $StockAssignmentFactory)
    {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
        $this->StockAssignmentFactory = $StockAssignmentFactory;
    }

    public function __invoke(array $param): void
    {
        $stockManagementType = $this->getStockManagementType($param['product_id']);
        $productInventoryList = $this->getProductInventoryList($param['product_id']);

        try {
            DB::transaction(function () use ($stockManagementType, $productInventoryList, $param) {
                $order = $this->createOrder($param);
                $this->assignStock($stockManagementType, $productInventoryList, $param['order_count'], $order);
            });
        } catch (InvalidArgumentException | OutOfStockException $e) {
            throw new DomainValidationException($e->getMessage());
        }
    }

    /**
     * 在庫管理タイプを取得する
     */
    protected function getStockManagementType(int $productId): StockManagementType
    {
        return $this->productRepository->find($productId)->stock_management_type;
    }

    /**
     * 商品の在庫リストを取得する
     */
    protected function getProductInventoryList(int $productId): Collection
    {
        return $this->productRepository->find($productId)->productInventories;
    }

    /**
     * 注文を作成する
     */
    protected function createOrder(array $param): Order
    {
        return $this->orderRepository->create($param);
    }

    /**
     * 在庫を割り当てる
     */
    protected function assignStock(StockManagementType $stockManagementType, $productInventoryList, int $orderCount, Order $order): void
    {
        $stockAssignment = $this
            ->StockAssignmentFactory
            ->create($stockManagementType);
        
        $stockAssignment
            ->assignStock(
                $productInventoryList,
                $orderCount,
                $order->id
            );
    }
}