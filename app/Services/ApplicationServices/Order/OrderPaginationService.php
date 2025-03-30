<?php

namespace App\Services\ApplicationServices\Order;

use App\Models\Order;
use App\Repository\OrderRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderPaginationService
{
    protected OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function __invoke(int $perPage): LengthAwarePaginator
    {
        return $this->orderRepository->paginate($perPage);
    }
}