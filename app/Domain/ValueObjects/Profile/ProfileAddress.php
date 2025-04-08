<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects\Profile;

class ProfileAddress
{
    /**
     * ProfileAddress クラスのインスタンスを初期化。
     *
     * @param string $address 文字列
     */
    public function __construct(private readonly string $address)
    {
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
