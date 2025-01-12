<?php

namespace App\UseCases\ProductInventory\Stock;

use App\Exceptions\OutOfStockException;
use App\Exceptions\StockLogicException;
use Illuminate\Database\Eloquent\Collection;

class FifoStockAssignment implements StockAssignmentInterface
{
    /**
     * 在庫を割り当て済みにする
     */
    public function assignStock(Collection $productInventoryList, int $count, int $orderId): void
    {
        // 作成日を基準にして降順にソート
        $productInventoryList = $productInventoryList->sortBy('created_at', SORT_REGULAR, false);

        foreach ($productInventoryList as $productInventory) {
            if ($count <= 0) {
                break;
            }

            if (!$productInventory->hasOrder()) {
                $productInventory->assign($orderId)->save();
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
    public function unAssignStock(Collection $productInventoryList, int $count, int $orderId): void
    {
        // 作成日を基準にして降順にソート
        $productInventoryList = $productInventoryList->sortBy('created_at', SORT_REGULAR, true);

        foreach ($productInventoryList as $productInventory) {
            if ($count <= 0) {
                break;
            }

            if ($productInventory->isAssignedToOrder($orderId)) {
                $productInventory->unAssign()->save();
                $count--;
            }
        }

        if ($count > 0) {
            throw new StockLogicException();
        }
    }
}