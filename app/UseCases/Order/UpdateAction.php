<?php

namespace App\UseCases\Order;

use App\Models\Order;

class UpdateAction
{
    public function __invoke(Order $order, array $param): Order
    {
        $order->fill($param)->save();

        return $order;
    }
}