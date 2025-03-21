<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

class ArticleServiceId
{
    private int $value;

    /**
     * ArticleServiceId の新しいインスタンスを生成します。
     *
     * 渡された整数値を内部プロパティに設定し、オブジェクトを初期化します。
     *
     * @param int $value 初期値として設定する整数
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * 格納されている整数値を取得します。
     *
     * @return int 保持されている整数値
     */
    public function value(): int
    {
        return $this->value;
    }

    /**
     * 別のArticleServiceIdオブジェクトと等価であるかを比較します。
     *
     * @param  ArticleServiceId $other 比較対象のオブジェクト
     * @return bool 等価である場合はtrue、そうでない場合はfalse
     */
    public function equals(ArticleServiceId $other): bool
    {
        return $this->value === $other->value();
    }
}
