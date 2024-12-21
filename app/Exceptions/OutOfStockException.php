<?php

namespace App\Exceptions;

use Exception;

/**
 * 在庫が足りない場合の例外
 */
class OutOfStockException extends Exception
{
    /**
     * 例外を生成する
     * @param string $message 固有の例外メッセージを指定したい場合に渡される
     */
    public function __construct(string $message = '在庫が足りません')
    {
        parent::__construct($message);
    }
}