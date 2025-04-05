<?php

declare(strict_types=1);

namespace App\Application\UseCases\Profile;

use App\Application\DTOs\ProfileDto;

/**
 * Profile情報を更新.
 */
interface UpdateProfileUseCaseInterface
{
    /**
     * Profile情報を更新.
     *
     * @param ProfileDto $dto 更新対象のDTO
     *
     * @throws \DomainException
     * @throws \RuntimeException
     */
    public function execute(ProfileDto $dto): void;
}
