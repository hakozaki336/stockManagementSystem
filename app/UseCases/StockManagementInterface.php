<?php

namespace App\UseCases;

use Illuminate\Database\Eloquent\Collection;

interface StockManagementInterface
{
    /**
     * 在庫をカウント分割り当て済みにする
     */
    public function reduceStock(Collection $productInventoryList, int $count): void;

    /**
     * 在庫をカウント分非割り当てにする
     */
    public function increaseStock(Collection $productInventoryList, int $count): void;
}