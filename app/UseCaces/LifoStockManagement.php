<?php

namespace App\UseCases;

use Illuminate\Database\Eloquent\Collection;

class LifoStockManagement
{
        /**
     * 在庫を割り当て済みにする
     */
    public function reduceStock(Collection $productInventoryList, int $count): void
    {
        // 作成日を基準にして昇順にソート
        $productInventoryList = $productInventoryList->sortBy('created_at', SORT_REGULAR, false);

        // カウント分割り当て済みにする
        foreach ($productInventoryList as $productInventory) {
            if ($count <= 0) {
                break;
            }

            if ($productInventory->dispatched === false) {
                $productInventory->dispatched = true;
                $productInventory->save();
                $count--;
            }
        }
    }

    /**
     * 在庫を非割り当てにする
     */
    public function increaseStock(Collection $productInventoryList, int $count): void
    {
        // 作成日を基準にして昇順にソート
        $productInventoryList = $productInventoryList->sortBy('created_at', SORT_REGULAR, false);

        // カウント分非割り当てにする
        foreach ($productInventoryList as $productInventory) {
            if ($count <= 0) {
                break;
            }

            if ($productInventory->dispatched === true) {
                $productInventory->dispatched = false;
                $productInventory->save();
                $count--;
            }
        }
    }
}