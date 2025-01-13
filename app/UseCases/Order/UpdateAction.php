<?php

namespace App\UseCases\Order;

use App\Models\Order;

class UpdateAction
{
    public function __invoke(Order $order, array $param): bool
    {
        return $this->updateOrder($order, $param);
    }

    /**
     * 注文を更新する
     */
    protected function updateOrder($order, array $param): bool
    {
        return $order->fill($param)->save();
    }
}