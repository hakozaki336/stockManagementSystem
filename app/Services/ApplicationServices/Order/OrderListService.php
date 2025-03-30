<?php

namespace App\Services\ApplicationServices\Order;

use App\Repository\OrderRepository;
use Illuminate\Database\Eloquent\Collection;

class OrderListService
{
    protected OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function __invoke(): Collection
    {
        return $this->orderRepository->all();
    }
}