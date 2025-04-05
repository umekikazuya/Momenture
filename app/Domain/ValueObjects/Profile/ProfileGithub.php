<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects\Profile;

class ProfileGithub
{
    /**
     * ProfileGithub クラスのインスタンスを初期化。
     *
     * @param string  $github  文字列
     *
     * @throws \DomainException 無効なGithubアカウント名が指定された場合
     */
    /**
     * ProfileGithub クラスのインスタンスを初期化。
     *
     * @param string $github 文字列
     *
     * @throws \DomainException 無効なGithubアカウント名が指定された場合
     */
    public function __construct(private readonly string $github)
    {
        // アカウント名のバリデーション
        // 空でないこと、特殊文字を含まないこと、最大長の制限など
        if (! $this->isValidGithubAccount($github)) {
            throw new \DomainException('無効なGithubアカウント名です: '.$github);
        }
    }

    /**
     * Githubアカウント名が有効かどうかを検証
     *
     * @param  string $github Githubアカウント名
     * @return bool 有効な場合はtrue、そうでない場合はfalse
     */
    private function isValidGithubAccount(string $github): bool
    {
        return ! empty($github) && preg_match('/^[a-z\d](?:[a-z\d]|-(?=[a-z\d])){0,38}$/i', $github);
    }

    /**
     * 格納されたGithubを取得。
     *
     * コンストラクタで設定された、有効なGithubアカウント名の文字列を返す。
     *
     * @return string 保持されているGithub文字列
     */
    public function value(): string
    {
        return $this->github;
    }
}
