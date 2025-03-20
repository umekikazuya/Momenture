<?php

namespace App\Domain\ValueObjects;

class ArticleTitle
{
    private string $value;

    /**
     * コンストラクタ。
     *
     * 与えられた記事タイトルを検証し、初期化します。
     * 記事タイトルが空白のみ、または100文字を超える場合は、DomainExceptionをスローします。
     *
     * @param string $value 記事タイトルの文字列
     * @throws \DomainException 記事タイトルが空白または100文字を超える場合にスローされます。
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
     * 記事タイトルの値を返します。
     *
     * ArticleTitleオブジェクトに格納されている記事タイトル文字列を取得します。
     *
     * @return string 保存されている記事タイトル
     */
    public function value(): string
    {
        return $this->value;
    }
}
