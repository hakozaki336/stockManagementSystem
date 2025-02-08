<?php

namespace App\Enums;

enum ProductArea: int
{
    case A1 = 0;
    case B1 = 1;
    case C1 = 2;

    public function label(): string
    {
        return match ($this) {
            self::A1 => '本社A1保管庫',
            self::B1 => '大阪支部B1保管庫',
            self::C1 => '名古屋支部C1保管庫',
        };
    }
}