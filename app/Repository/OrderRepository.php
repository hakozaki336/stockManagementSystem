<?php

namespace App\Repository;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderRepository
{
    public function all(): Collection
    {
        return Order::all();
    }

    public function delete(Order $order): ?bool
    {
        return $order->delete();
    }

    public function paginate(int $perPage): LengthAwarePaginator
    {
        return Order::paginate($perPage);
    }

    public function create(array $params): Order
    {
        return Order::create($params);
    }

    public function update(Order $order, array $params): Order
    {
        $order->update($params);
        return $order;
    }
}