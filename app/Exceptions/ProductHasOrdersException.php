<?php

namespace App\Exceptions;

use Exception;

/**
 * 商品が注文と関連している場合の例外
 */
class ProductHasOrdersException extends Exception
{
    /**
     * 例外を生成する
     * @param string $message 固有の例外メッセージを指定したい場合に渡される
     */
    public function __construct($message = "この商品は注文と関連しているため削除できません。")
    {
        parent::__construct($message);
    }
}