<?php

namespace App\Services\ApplicationServices\Order;

use App\Events\OrderShippedEvent;
use App\Models\Order;
use App\Models\User;
use App\Repository\OrderRepository;
use Illuminate\Database\Eloquent\Collection;

class OrderShippedService
{
    public function __invoke(Order $order, User $user): void
    {
        $order->assign()->save();
        OrderShippedEvent::dispatch($order, $user);
    }
}