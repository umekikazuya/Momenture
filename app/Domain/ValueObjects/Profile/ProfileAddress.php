<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects\Profile;

class ProfileAddress
{
    /**
     * ProfileAddress クラスのインスタンスを初期化。
     *
     * 渡された文字列が有効な形式かどうか検証し、無効な場合は DomainException をスロー。
     *
     * @param string $address 文字列
     *
     * @throws \DomainException 無効なAddressが指定された場合
     */
    public function __construct(private readonly string $address)
    {
        $this->address = $address;
    }

    /**
     * 格納されたAddressを取得。
     *
     * コンストラクタで設定された、有効なAddressの文字列を返す。
     *
     * @return string 保持されているAddress文字列
     */
    public function value(): string
    {
        return $this->address;
    }
}
