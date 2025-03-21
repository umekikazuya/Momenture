<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

class FeaturedPriority
{
    /**
     * FeaturedPriority クラスのインスタンスを生成するコンストラクタ。
     *
     * 渡された優先度の値が1以上であることを保証し、1未満の場合は例外をスローします。
     *
     * @param int $value 優先度を表す整数値
     * @throws \InvalidArgumentException 優先度が1以上でない場合
     */
    public function __construct(private int $value)
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException('優先度は1以上である必要があります');
        }
    }

    /**
     * インスタンスが保持する優先度の整数値を返却します。
     *
     * @return int 優先度の値
     */
    public function value(): int
    {
        return $this->value;
    }

    /**
     * 現在の優先度が、指定された比較対象の優先度より高いか判定する。
     *
     * 優先度は数値で管理され、小さい数字ほど高い優先度を表します。
     *
     * @param FeaturedPriority $other 比較対象の優先度オブジェクト
     * @return bool 現在の優先度が比較対象より高い場合は true を返します。
     */
    public function isHigherThan(FeaturedPriority $other): bool
    {
        return $this->value < $other->value; // 数字が小さいほど優先度高い
    }
}
