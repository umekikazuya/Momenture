<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects\Profile;

class ProfileGithub
{
    /**
     * ProfileGithub クラスのインスタンスを初期化。
     *
     * @param string $github 文字列
     *
     * @throws \DomainException 無効なGithubアカウント名が指定された場合
     */
    public function __construct(private readonly string $github)
    {
        $this->isValid($github);
    }

    /**
     * Githubアカウント名が有効かどうかを検証
     *
     * @param  string $github Githubアカウント名
     * @return void
     *
     * @throws \DomainException 無効なGithubアカウント名が指定された場合
     */
    private function isValid(string $github): void
    {
        // アルファベット、数字、ハイフン、アンダースコアのみを許可
        if (!preg_match('/^[a-zA-Z0-9_-]+$/', $github)) {
            throw new \DomainException('無効なGithubアカウント名: ' . $github);
        }
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
