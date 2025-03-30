<?php

namespace App\UseCases\ProductInventory\Stock;

use App\Enums\StockManagementType;
use InvalidArgumentException;

class StockAssignmentFactory
{
    public function create(StockManagementType $stockManagementType): StockAssignmentInterface
    {
        return match ($stockManagementType) {
            StockManagementType::FIFO => new FifoStockAssignment(),
            StockManagementType::LIFO => new LifoStockAssignment(),
            default => throw new InvalidArgumentException('在庫管理タイプが不正です'),
        };
    }
}
