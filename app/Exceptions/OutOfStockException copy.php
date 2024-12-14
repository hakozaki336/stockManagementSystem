<?php

namespace App\Exceptions;

use Exception;

/**
 * 在庫ロジックで不整合が発生した場合の例外
 */
class StockLogicException extends Exception
{
    /**
     * 例外を生成する
     * @param string $message 固有の例外メッセージを指定したい場合に渡される
     */
    public function __construct(string $message = '在庫ロジックで不整合が発生しました')
    {
        parent::__construct($message);
    }
}