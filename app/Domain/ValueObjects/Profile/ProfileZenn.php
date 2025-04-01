<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects\Profile;

class ProfileZenn
{
    /**
     * ProfileZenn クラスのインスタンスを初期化。
     *
     * @param  string  $zenn  文字列
     *
     * @throws \DomainException 無効なZennが指定された場合
     */
    public function __construct(private readonly string $zenn) {}

    /**
     * 格納されたZennを取得。
     *
     * コンストラクタで設定された、有効なZennの文字列を返す。
     *
     * @return string 保持されているZenn文字列
     */
    public function value(): string
    {
        return $this->zenn === '' ? null : $this->zenn;
    }
}
