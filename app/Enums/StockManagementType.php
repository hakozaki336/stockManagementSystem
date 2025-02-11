<?php

namespace App\Enums;

enum StockManagementType: int
{
    case FIFO = 0;
    case LIFO = 1;

    public function label(): string
    {
        return match ($this) {
            self::FIFO => '先入れ先出し',
            self::LIFO => '後入れ先出し',
        };
    }
}