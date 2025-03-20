<?php

namespace App\Domain\ValueObjects;

class ArticleTitle
{
    private string $value;

    /**
     * 入力された記事タイトルを検証し、ArticleTitleのインスタンスを生成する。
     *
     * 渡された$titleは、空白のみではなく、100文字以内である必要があります。
     * 空白のみの場合は「記事タイトルは空白にできません。」、100文字を超える場合は
     * 「記事タイトルは100文字以内にしてください。」というメッセージとともに、
     * \DomainExceptionがスローされます。
     *
     * @param string $value 記事のタイトル
     *
     * @throws \DomainException タイトルが空白または100文字を超えた場合にスローされる
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
     * 格納されている記事タイトルを返します。
     *
     * バリデーション済みのタイトルが格納されたプロパティから、記事タイトルの文字列を取得します。
     *
     * @return string 記事タイトルの文字列
     */
    public function value(): string
    {
        return $this->value;
    }
}
