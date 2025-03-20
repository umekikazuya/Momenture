<?php

namespace App\Domain\ValueObjects;

class ArticleLink
{
    private string $url;

    /**
     * 指定されたURLを検証し、ArticleLinkインスタンスを初期化する。
     *
     * 与えられたURLが有効な形式でない場合、無効なURLである旨のメッセージとともにDomainExceptionをスローします。
     *
     * @param string $url 検証対象のURL文字列
     *
     * @throws \DomainException 無効なURLが渡された場合にスローされる
     */
    public function __construct(string $url)
    {
        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \DomainException('無効なURLです: ' . $url);
        }
        $this->url = $url;
    }

    /**
     * インスタンスに保持されている検証済みのURLを返します。
     *
     * @return string 保持されている有効なURL
     */
    public function value(): string
    {
        return $this->url;
    }
}
