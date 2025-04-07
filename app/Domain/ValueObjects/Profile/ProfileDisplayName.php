<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects\Profile;

final class ProfileDisplayName
{
    /**
     * ProfileDisplayName クラスのインスタンスを初期化。
     *
     * 渡された文字列が有効な形式かどうか検証し、無効な場合は DomainException をスロー。
     *
     * @param string $displayName 文字列
     *
     * @throws \DomainException 無効なDisplayNameの場合
     */
    public function __construct(private readonly string $displayName)
    {
        if (trim($displayName) === '') {
            throw new \DomainException('DisplayNameは空にできません。');
        }
        if (mb_strlen($displayName) > 50) {
            throw new \DomainException('DisplayNameは50文字以内で指定してください。');
        }
    }

    /**
     * 格納されたDisplayNameを取得。
     *
     * コンストラクタで設定された、有効なDisplayNameの文字列を返す。
     *
     * @return string 保持されているDisplayName文字列
     */
    public function value(): string
    {
        return $this->displayName;
    }
}
