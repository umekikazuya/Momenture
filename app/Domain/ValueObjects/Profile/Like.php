<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects\Profile;

final class Like
{
    /**
     * Like クラスのインスタンスを初期化。
     *
     * 渡された文字列が有効な形式かどうか検証し、無効な場合は DomainException をスロー。
     *
     * @param string $value 文字列
     *
     * @throws \DomainException 無効なLikeが指定された場合
     */
    public function __construct(private string $value)
    {
        // 空文字列は無効
        if (trim($value) === '') {
            throw new \DomainException('Like は空にできません。');
        }
        // 50文字以上は無効
        if (mb_strlen($value) > 50) {
            throw new \DomainException('Like は50文字以内にしてください。');
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(Like $other): bool
    {
        return $this->value === $other->value();
    }
}
