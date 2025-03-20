<?php

namespace App\Domain\ValueObjects;

class ArticleLink
{
    private string $url;

    /**
     * ArticleLink クラスのコンストラクタ。
     *
     * 渡された URL を検証し、有効な場合に内部プロパティとして設定します。
     * 無効な URL の場合は、詳細な情報を含む DomainException がスローされます。
     *
     * @param string $url 検証対象の URL 文字列
     * @throws \DomainException 無効な URL が渡された場合にスローされます
     */
    public function __construct(string $url)
    {
        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \DomainException('無効なURLです: ' . $url);
        }
        $this->url = $url;
    }

    /**
     * ArticleLinkに保持されたURLを文字列として返します。
     *
     * このメソッドは、ArticleLinkインスタンスに格納された有効なURLを返します。
     *
     * @return string URLを表す文字列
     */
    public function value(): string
    {
        return $this->url;
    }
}
