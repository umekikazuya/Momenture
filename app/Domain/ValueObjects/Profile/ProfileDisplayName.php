<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects\Profile;

final class ProfileDisplayName
{
    /**
     * ProfileDisplayName クラスのインスタンスを初期化。
     *
     * @param string $displayName 文字列
     */
    public function __construct(private readonly string $displayName)
    {
    }

    /**
     * 格納されたDisplayNameを取得。
     *
     * コンストラクタで設定された、有効なDisplayNameの文字列を返す。
     *
     * @return string 保持されているDisplayName文字列
     */
    public function value(): string
    {
        return $this->displayName;
    }
}
