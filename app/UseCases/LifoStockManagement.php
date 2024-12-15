<?php

namespace App\UseCases;

use App\Exceptions\OutOfStockException;
use App\Exceptions\StockLogicException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

use function Illuminate\Log\log;

class LifoStockManagement implements StockManagementInterface
{
    /**
     * 在庫を割り当て済みにする
     */
    public function dispatchStock(Collection $productInventoryList, int $count): void
    {
        // 作成日を基準にして昇順にソート
        $productInventoryList = $productInventoryList->sortBy('created_at', SORT_REGULAR, true);

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

        if ($count > 0) {
            throw new OutOfStockException();
        }
    }

    /**
     * 在庫を非割り当てにする
     */
    public function undispatchStock(Collection $productInventoryList, int $count): void
    {
        // 作成日を基準にして昇順にソート
        $productInventoryList = $productInventoryList->sortBy('created_at', SORT_REGULAR, false);

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

        if ($count > 0) {
            throw new StockLogicException();
        }
    }
}