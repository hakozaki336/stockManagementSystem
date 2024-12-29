<?php

namespace App\Exceptions;

use Exception;

/**
 * ドメインバリデーションの例外
 */
class DomainValidationException extends Exception
{
    /**
     * 例外を生成する
     * @param string $message 固有の例外メッセージを指定したい場合に渡される
     */
    public function __construct(string $message = 'ドメインバリデーションでエラーが発生しました')
    {
        parent::__construct($message);
    }
}