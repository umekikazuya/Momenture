<?php

namespace App\Domain\ValueObjects;

class ArticleLink
{
    private string $url;

    /**
     * ArticleLink クラスのインスタンスを初期化します。
     *
     * 渡された URL が有効な形式かどうか検証し、無効な場合は DomainException をスローします。
     *
     * @param string $url URL 文字列
     * @throws \DomainException 無効な URL が指定された場合
     */
    public function __construct(string $url)
    {
        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \DomainException('無効なURLです: ' . $url);
        }
        $this->url = $url;
    }

    /**
     * 格納されたURLを取得します。
     *
     * コンストラクタで設定された、有効なURLの文字列を返します。
     *
     * @return string 保持されているURL文字列
     */
    public function value(): string
    {
        return $this->url;
    }
}
