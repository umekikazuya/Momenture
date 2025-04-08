<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects\Profile;

final class ProfileGithub
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
     * Githubアカウント名が有効かどうかを検証(空文字は許可)
     *
     * @param  string $github Githubアカウント名
     * @return void
     *
     * @throws \DomainException 無効なGithubアカウント名が指定された場合
     */
    private function isValid(string $github): void
    {
        // 空文字は許可.
        if ($github === '') {
            return;
        }

        if (mb_strlen($github) > 39) {
            throw new \DomainException('Githubアカウント名は39文字以内で指定してください。');
        }

        if (!preg_match('/^[a-zA-Z0-9]+(?:[-_][a-zA-Z0-9]+)*$/', $github)) {
            throw new \DomainException('Githubアカウント名は半角英数字、ハイフン、アンダースコアのみ使用できます。');
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
