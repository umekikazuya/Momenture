<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects\Profile;

class ProfileGithub
{
    /**
     * ProfileGithub クラスのインスタンスを初期化。
     *
     * @param  string  $github  文字列
     *
     * @throws \DomainException 無効なGithubが指定された場合
     */
    public function __construct(private readonly string $github) {}

    /**
     * 格納されたGithubを取得。
     *
     * コンストラクタで設定された、有効なGithubの文字列を返す。
     *
     * @return string 保持されているGithub文字列
     */
    public function value(): string
    {
        return $this->github === '' ? null : $this->github;
    }
}
