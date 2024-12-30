<?php

namespace App\UseCases\ProductInventory\Stock;

use App\Exceptions\OutOfStockException;
use App\Exceptions\StockLogicException;
use Illuminate\Database\Eloquent\Collection;

class LifoStockAssignment implements StockAssignmentInterface
{
    /**
     * 在庫を割り当て済みにする
     */
    public function dispatchStock(Collection $productInventoryList, int $count, int $orderId): void
    {
        // 作成日を基準にして昇順にソート
        $productInventoryList = $productInventoryList->sortBy('created_at', SORT_REGULAR, true);

        foreach ($productInventoryList as $productInventory) {
            if ($count <= 0) {
                break;
            }

            if ($productInventory->order_id === null) {
                $productInventory->order_id = $orderId;
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
    public function undispatchStock(Collection $productInventoryList, int $count, int $orderId): void
    {
        // 作成日を基準にして昇順にソート
        // NOTE: そもそもnullのみを取得すれば良いのでは？
        $productInventoryList = $productInventoryList->sortBy('created_at', SORT_REGULAR, false);

        foreach ($productInventoryList as $productInventory) {
            if ($count <= 0) {
                break;
            }

            if ($productInventory->order_id === $orderId) {
                $productInventory->order_id = null;
                $productInventory->save();
                $count--;
            }
        }

        if ($count > 0) {
            throw new StockLogicException();
        }
    }
}