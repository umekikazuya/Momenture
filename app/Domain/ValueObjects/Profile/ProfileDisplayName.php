<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects\Profile;

class ProfileDisplayName
{
    /**
     * ProfileDisplayName クラスのインスタンスを初期化。
     *
     * 渡された文字列が有効な形式かどうか検証し、無効な場合は DomainException をスロー。
     *
     * @param  string  $displayName  文字列
     *
     * @throws \DomainException 無効なDisplayNameが指定された場合
     */
    public function __construct(private readonly string $displayName) {}

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
