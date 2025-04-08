<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects\Profile;

final class ProfileFrom
{
    /**
     * ProfileFrom クラスのインスタンスを初期化。
     *
     * @param string $from 文字列
     */
    public function __construct(private readonly string $from)
    {
    }

    /**
     * 格納されたFromを取得。
     *
     * コンストラクタで設定された、有効なFromの文字列を返す。
     *
     * @return string 保持されているFrom文字列
     */
    public function value(): string
    {
        return $this->from;
    }
}
