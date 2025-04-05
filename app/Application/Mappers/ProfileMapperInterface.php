<?php

declare(strict_types=1);

namespace App\Application\Mappers;

use App\Application\DTOs\ProfileDto;
use App\Domain\Entities\Profile;

interface ProfileMapperInterface
{
    /**
     * ProfileDtoをProfileエンティティに変換.
     *
     * @param ProfileDto $dto
     *
     * @return Profile
     */
    public function toEntity(ProfileDto $dto): Profile;

    /**
     * ProfileエンティティをProfileDtoに変換.
     *
     * @param Profile $entity
     *
     * @return ProfileDto
     */
    public function toDto(Profile $entity): ProfileDto;
}
