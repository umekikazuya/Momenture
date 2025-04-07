<?php

declare(strict_types=1);

namespace App\Application\UseCases\Profile;

use App\Application\DTOs\ProfileDto;
use App\Domain\Entities\Profile;

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
     * @return Profile 更新後のProfileエンティティ
     *
     * @throws \DomainException
     * @throws \RuntimeException
     */
    public function execute(ProfileDto $dto): Profile;
}
