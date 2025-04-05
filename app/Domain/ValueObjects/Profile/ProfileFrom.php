<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects\Profile;

final class ProfileFrom
{
    /**
     * ProfileFrom クラスのインスタンスを初期化。
     *
     * 渡された文字列が有効な形式かどうか検証し、無効な場合は DomainException をスロー。
     *
     * @param string $from 文字列
     *
     * @throws \DomainException 無効なFromが指定された場合
     */
    public function __construct(private readonly string $from)
    {
        if (trim($from) === '') {
            throw new \DomainException('Fromは空にできません。');
        }
        if (mb_strlen($from) > 100) {
            throw new \DomainException('Fromは100文字以内で指定してください。');
        }
    }

    /**
     * 格納されたFromを取得。
     *
     * コンストラクタで設定された、有効なFromの文字列を返す。
     *
     * @return string 保持されているFrom文字列
     */
    public function value(): string
    {
        return $this->from;
    }
}
