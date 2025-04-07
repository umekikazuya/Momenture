<?php

declare(strict_types=1);

namespace App\Application\Mappers;

use App\Application\DTOs\ProfileDto;
use App\Domain\Entities\Profile;

interface ProfileMapperInterface
{
    /**
     * ProfileDtoからProfileエンティティに変換する
     *
     * @param ProfileDto $dto
     *
     * @return Profile
     *
     * @throws \DomainException
     */
    public function toEntity(ProfileDto $dto): Profile;

    /**
     * Profileエンティティから ProfileDtoに変換する
     *
     * @param Profile $entity
     *
     * @return ProfileDto
     *
     * @throws \DomainException
     */
    public function toDto(Profile $entity): ProfileDto;
}
