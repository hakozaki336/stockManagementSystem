<?php

namespace App\UseCases;

use App\UseCases\FifoStockManagement;
use App\UseCases\LifoStockManagement;
use App\UseCases\StockManagementInterface;
use InvalidArgumentException;

class StockManagementFactory
{
    public static function create(string $stockManagementType): StockManagementInterface
    {
        return match ($stockManagementType) {
            'FIFO' => new FifoStockManagement(),
            'LIFO' => new LifoStockManagement(),
            default => throw new InvalidArgumentException('在庫管理タイプが不正です'),
        };
    }
}
