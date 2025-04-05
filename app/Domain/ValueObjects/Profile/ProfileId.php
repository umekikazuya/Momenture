<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects\Profile;

class ProfileId
{
    /**
     * ProfileId クラスのインスタンスを初期化。
     *
     * 渡されたIDが有効な値であるかどうか検証し、無効な場合は DomainException をスロー。
     *
     * @param int $id ID
     *
     * @throws \DomainException 無効なIDが指定された場合
     */
    public function __construct(private readonly int $id)
    {
        if ($id <= 0) {
            throw new \DomainException('無効なIdです: ' . $id);
        }
    }

    /**
     * Getter for id.
     *
     * コンストラクタで設定された、有効なIDの整数。
     *
     * @return int 保持されているID
     */
    public function value(): int
    {
        return $this->id;
    }
}
