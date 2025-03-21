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
}
