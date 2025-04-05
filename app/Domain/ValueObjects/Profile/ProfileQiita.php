<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects\Profile;

class ProfileQiita
{
    /**
     * ProfileQiita クラスのインスタンスを初期化。
     *
     * @param string $qiita アカウント名
     *
     * @throws \DomainException 無効なアカウント名が指定された場合
     */
    public function __construct(private readonly string $qiita)
    {
        $this->isValid($qiita);
    }

    /**
     * アカウント名が有効かどうかを検証
     *
     * @param  string $qiita アカウント名
     * @return void
     *
     * @throws \DomainException 無効なアカウント名が指定された場合
     */
    private function isValid(string $qiita): void
    {
        // 空文字は許可.
        if ($qiita === '') {
            return;
        }
        // アルファベット、数字、ハイフン、アンダースコアのみを許可
        if (!preg_match('/^[a-zA-Z0-9_-]+$/', $qiita)) {
            throw new \DomainException('無効なアカウント名: ' . $qiita);
        }
    }

    /**
     * 格納されたアカウント名を取得。
     *
     * コンストラクタで設定された、有効なアカウント名の文字列を返す。
     *
     * @return string 保持されているアカウント名文字列
     */
    public function value(): string
    {
        return $this->qiita;
    }
}
