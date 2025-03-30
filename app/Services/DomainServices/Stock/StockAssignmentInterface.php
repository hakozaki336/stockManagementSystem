<?php

namespace App\Services\DomainServices\Stock;

use Illuminate\Database\Eloquent\Collection;

interface StockAssignmentInterface
{
    /**
     * 在庫をカウント分割り当て済みにする
     */
    public function assignStock(Collection $productInventoryList, int $count, int $orderId): void;

    /**
     * 在庫をカウント分非割り当てにする
     */
    public function unassignStock(Collection $productInventoryList, int $count, int $orderId): void;
}