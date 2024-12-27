<?php

namespace App\UseCases\Order;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

class IndexAction
{
    private Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function __invoke(): Collection
    {
        return $this->order->all();
    }
}