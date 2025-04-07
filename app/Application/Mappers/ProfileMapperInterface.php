<?php

declare(strict_types=1);

namespace App\Application\Mappers;

use App\Application\DTOs\ProfileDto;
use App\Domain\Entities\Profile;

/**
 * ProfileDTOとProfileエンティティの変換を行うマッパーインターフェース
 */
interface ProfileMapperInterface
{
    /**
     * ProfileDtoからProfileエンティティに変換する
     *
     * @param ProfileDto $dto 変換元のDTO
     * @return Profile 変換後のエンティティ
     * @throws \DomainException 変換時に値オブジェクトの制約に違反した場合
     */
    public function toEntity(ProfileDto $dto): Profile;

    /**
     * ProfileエンティティからProfileDtoに変換する
     *
     * @param Profile $entity 変換元のエンティティ
     * @return ProfileDto 変換後のDTO
     */
    public function toDto(Profile $entity): ProfileDto;
}
