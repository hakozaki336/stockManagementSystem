<?php

namespace App\UseCases\Order;

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginateAction
{
    private Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function __invoke(int $perpage): LengthAwarePaginator
    {
        return $this->order->paginate($perpage);
    }
}