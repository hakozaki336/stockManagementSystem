<?php

namespace App\UseCases;

use App\Exceptions\OutOfStockException;
use Illuminate\Database\Eloquent\Collection;

class LifoStockManagement implements StockManagementInterface
{
    /**
     * 在庫を割り当て済みにする
     */
    public function reduceStock(Collection $productInventoryList, int $count): void
    {
        // 作成日を基準にして昇順にソート
        $productInventoryList = $productInventoryList->sortBy('created_at', SORT_REGULAR, true);

        $assignedCount = 0;
        foreach ($productInventoryList as $productInventory) {
            if ($count <= 0) {
                break;
            }

            if ($productInventory->dispatched === false) {
                $productInventory->dispatched = true;
                $productInventory->save();
                $assignedCount++;
                $count--;
            }
        }

        if ($assignedCount < $count) {
            throw new OutOfStockException();
        }
    }

    /**
     * 在庫を非割り当てにする
     */
    public function increaseStock(Collection $productInventoryList, int $count): void
    {
        // 作成日を基準にして昇順にソート
        $productInventoryList = $productInventoryList->sortBy('created_at', SORT_REGULAR, false);

        $assignedCount = 0;
        foreach ($productInventoryList as $productInventory) {
            if ($count <= 0) {
                break;
            }

            if ($productInventory->dispatched === true) {
                $productInventory->dispatched = false;
                $productInventory->save();
                $assignedCount++;
                $count--;
            }
        }

        if ($assignedCount < $count) {
            throw new OutOfStockException();
        }
    }
}