<?php

namespace App\UseCases\Order;

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginateAction
{
    public function __invoke(Order $order, int $perpage): LengthAwarePaginator
    {
        return $order->paginate($perpage);
    }
}