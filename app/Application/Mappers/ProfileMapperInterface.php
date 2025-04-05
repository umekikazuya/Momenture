<?php

declare(strict_types=1);

namespace App\Application\Mappers;

use App\Application\DTOs\ProfileDto;
use App\Domain\Entities\Profile;

interface ProfileMapperInterface
{
    /**
     * ProfileDtoからProfileエンティティに変換する
     */
    public function toEntity(ProfileDto $dto): Profile;

    /**
     * Profileエンティティから ProfileDtoに変換する
     */
    public function toDto(Profile $entity): ProfileDto;
}
