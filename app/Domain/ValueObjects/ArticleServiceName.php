<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

class ArticleServiceName
{
    private string $value;

    /**
     * サービス名を検証し、ArticleServiceNameオブジェクトを初期化する。
     *
     * 指定されたサービス名が空文字または空白のみの場合、または100文字を超える場合はDomainExceptionをスローする。
     *
     * @param string $value サービス名
     *
     * @throws \DomainException サービス名が空白の場合は「サービス名は空白にできません。」、または100文字を超える場合は「サービス名は100文字以内にしてください。」
     */
    public function __construct(string $value)
    {
        if (empty(trim($value))) {
            throw new \DomainException('サービス名は空白にできません。');
        }
        if (mb_strlen($value) > 100) {
            throw new \DomainException('サービス名は100文字以内にしてください。');
        }
        $this->value = $value;
    }

    /**
     * 格納されたサービス名を返します。
     *
     * このメソッドは、ArticleServiceName オブジェクトに設定されたサービス名の文字列を返却します。
     *
     * @return string サービス名
     */
    public function value(): string
    {
        return $this->value;
    }
}
