<?php

namespace App\UseCases\Order;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

class IndexAction
{
    public function __invoke(Order $order): Collection
    {
        return $order->all();
    }
}