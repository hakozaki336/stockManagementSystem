<?php

namespace App\UseCases;

use Illuminate\Database\Eloquent\Collection;

interface StockManagementInterface
{
    /**
     * 在庫をカウント分割り当て済みにする
     */
    public function dispatchStock(Collection $productInventoryList, int $count, int $orderId): void;

    /**
     * 在庫をカウント分非割り当てにする
     */
    public function undispatchStock(Collection $productInventoryList, int $count, int $orderId): void;
}