<?php

namespace App\UseCases\ProductInventory\Stock;

use InvalidArgumentException;

class StockAssignmentFactory
{
    public function create(string $stockManagementType): StockAssignmentInterface
    {
        return match ($stockManagementType) {
            'FIFO' => new FifoStockAssignment(),
            'LIFO' => new LifoStockAssignment(),
            default => throw new InvalidArgumentException('在庫管理タイプが不正です'),
        };
    }
}
