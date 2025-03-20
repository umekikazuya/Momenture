<?php

namespace App\Domain\ValueObjects;

class ArticleTitle
{
    private string $value;

    /**
     * 記事タイトルオブジェクトを初期化する。
     *
     * 入力されたタイトルが空白または100文字を超える場合、DomainExceptionをスローします。
     *
     * @param string $value 初期化する記事タイトル
     *
     * @throws \DomainException タイトルが空白または100文字を超える場合にスローされます。
     */
    public function __construct(string $value)
    {
        if (empty(trim($value))) {
            throw new \DomainException('記事タイトルは空白にできません。');
        }
        if (mb_strlen($value) > 100) {
            throw new \DomainException('記事タイトルは100文字以内にしてください。');
        }
        $this->value = $value;
    }

    /**
     * 内部に保持された記事タイトルを返す。
     *
     * @return string 記事タイトルの値
     */
    public function value(): string
    {
        return $this->value;
    }
}
