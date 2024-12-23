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
            $product = new ProductService($order['product_id']);
            $productInventory = new ProductInventoryService($product->getProduct());

            $productInventory->undispatchStock($order['order_count'], $order->id);
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

            $order = Order::create($orderParam);
            $productInventory->dispatchStock($orderParam['order_count'], $order->id);

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
