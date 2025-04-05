<?php

declare(strict_types=1);

namespace App\Application\UseCases\Profile;

use App\Domain\Entities\Profile;

/**
 * Profile情報を取得.
 *
 * @see \App\Application\UseCases\Profile\GetProfileUseCase
 */
interface GetProfileUseCaseInterface
{
    /**
     * Profile情報を取得.
     *
     * @throws \DomainException プロフィールが見つからない場合
     * @throws \RuntimeException データベース操作で例外が発生した場合
     */
    public function execute(): Profile;
}
