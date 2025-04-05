<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects\Profile;

class ProfileShortName
{
    /**
     * ProfileShortName クラスのインスタンスを初期化。
     *
     * 渡された文字列が有効な形式かどうか検証し、無効な場合は DomainException をスロー。
     *
     * @param string $shortName
     *                             文字列.
     *
     * @throws \DomainException 無効なShortNameが指定された場合
     */
    public function __construct(private readonly string $shortName)
    {
    }

    /**
     * 格納されたShortNameを取得。
     *
     * コンストラクタで設定された、有効なShortNameの文字列を返す。
     *
     * @return string 保持されているShortName文字列
     */
    public function value(): string
    {
        return $this->shortName;
    }
}
