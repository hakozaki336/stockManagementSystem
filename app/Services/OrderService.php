<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderService
{
    /**
     * ページネーションされたOrderを取得する
     */
    public function getPaginatedOrders(int $perPage): LengthAwarePaginator
    {
        // TODO: リポジトリを使ってみるのも良いかもしれない
        $paginatedOrders = Order::with('product', 'company')->paginate($perPage);

        return $paginatedOrders;
    }

    /**
     * Orderを削除する
     */
    public function delete(Order $order): void
    {
        // TODO: DIできないか検討する
        $product = new ProductService($order->product_id);
        $product->increaseStock($order->order_count);

        $order->delete();
    }

    /**
     * Orderを作成する
     */
    public function store(array $orderParam): void
    {
        $product = new ProductService($orderParam['product_id']);
        $product->decreaseStock($orderParam['order_count']);

        Order::create($orderParam);
    }
}