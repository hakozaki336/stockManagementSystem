<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * ページネーションされたOrderを取得する
     */
    public function getPaginatedOrders(int $perPage): LengthAwarePaginator
    {
        // TODO: リポジトリを使ってみるのも良いかもしれない
        $paginatedOrders = Order::with('product', 'company')
            ->orderBy('dispatched', 'asc')
            ->paginate($perPage);

        return $paginatedOrders;
    }

    /**
     * Orderを削除する
     */
    public function delete(Order $order): void
    {
        DB::transaction(function () use ($order) {
            // TODO: DIできないか検討する
            $product = new ProductService($order->product_id);
            $product->increaseStock($order->order_count);

            $order->delete();
        });
    }

    /**
     * Orderを作成する
     */
    public function store(array $orderParam): void
    {
        DB::transaction(function () use ($orderParam) {
            $product = new ProductService($orderParam['product_id']);
            $productInventory = new ProductInventoryService($product->getProduct());
            $productInventory->dispatchStock($orderParam['order_count']);

            Order::create($orderParam);
        });
    }

    /**
     * Orderを更新する
     */
    public function update(Order $order, array $orderParam): void
    {
        $newProductService = new ProductService($orderParam['product_id']);
        $oldProductService = new ProductService($order->product_id);
        
        DB::transaction(function () use ($order, $orderParam, $newProductService, $oldProductService) {
            $newProductService->increaseStock($order->order_count);
            $oldProductService->decreaseStock($orderParam['order_count']);

            $order->update($orderParam);
        });
    }

    /**
     * Order.dispatchを割り当て済みにする
     */
    public function dispatch(Order $order): void
    {
        $order->dispatched = true;
        $order->save();
    }

    /**
     * Order.dispatchを未割り当てにする
     */
    public function undispatch(Order $order): void
    {
        $order->dispatched = false;
        $order->save();
    }
}
