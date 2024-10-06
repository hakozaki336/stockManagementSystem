<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

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
        $order->delete();
    }
}