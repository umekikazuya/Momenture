<?php

declare(strict_types=1);

namespace App\Application\Factories;

/**
 * DTO からエンティティを生成するファクトリインターフェース.
 */
interface EntityFactoryInterface
{
    /**
     * DTOからエンティティを生成する
     *
     * @param mixed $dto データ転送オブジェクト
     * @return mixed 生成されたエンティティ
     */
    public static function fromDto($dto);
}
