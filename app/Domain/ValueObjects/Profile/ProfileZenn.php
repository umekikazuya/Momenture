<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects\Profile;

class ProfileZenn
{
    /**
     * ProfileZenn クラスのインスタンスを初期化。
     *
     * @param string $zenn 文字列
     *
     * @throws \DomainException 無効なZennアカウント名が指定された場合
     */
    public function __construct(private readonly string $zenn)
    {
        $this->isValid($zenn);
    }

    /**
     * Zennアカウント名が有効かどうかを検証
     *
     * @param  string $zenn Zennアカウント名
     * @return void
     *
     * @throws \DomainException 無効なZennアカウント名が指定された場合
     */
    private function isValid(string $zenn): void
    {
        // アルファベット、数字、ハイフン、アンダースコアのみを許可
        if (!preg_match('/^[a-zA-Z0-9_-]+$/', $zenn)) {
            throw new \DomainException('無効なZennアカウント名: ' . $zenn);
        }
    }

    /**
     * Getter.
     *
     * コンストラクタで設定された、有効なZennの文字列を返す。
     *
     * @return string 保持されているZenn文字列
     */
    public function value(): string
    {
        return $this->zenn;
    }
}
