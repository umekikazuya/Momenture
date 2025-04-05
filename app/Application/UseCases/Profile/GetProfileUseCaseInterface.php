<?php

declare(strict_types=1);

namespace App\Application\UseCases\Profile;

use App\Application\DTOs\ProfileDto;


/**
 * Profile情報を取得.
 *
 * @see \App\Application\UseCases\Profile\GetProfileUseCase
 */
interface GetProfileUseCaseInterface
{
    /**
     * Profile情報を取得.
     */
    public function execute(): ProfileDto;
}
