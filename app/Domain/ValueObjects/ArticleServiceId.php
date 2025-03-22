<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

class ArticleServiceId
{
    /**
     * ArticleServiceId の新しいインスタンスを生成。
     *
     * 渡された整数値を内部プロパティに設定し、オブジェクトを初期化。
     *
     * @param int $value 初期値として設定する整数
     */
    public function __construct(private readonly int $value)
    {
    }

    /**
     * 格納されている整数値を取得。
     *
     * @return int 保持されている整数値
     */
    public function value(): int
    {
        return $this->value;
    }

    /**
     * 別のArticleServiceIdオブジェクトと等価であるかを比較。
     *
     * @param  ArticleServiceId $other 比較対象のオブジェクト
     * @return bool 等価である場合はtrue、そうでない場合はfalse
     */
    public function equals(ArticleServiceId $other): bool
    {
        return $this->value === $other->value();
    }
}
