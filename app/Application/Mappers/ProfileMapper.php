<?php

declare(strict_types=1);

namespace App\Application\Mappers;

use App\Application\DTOs\ProfileDto;
use App\Domain\Entities\Profile;
use App\Domain\ValueObjects\Profile\Like;
use App\Domain\ValueObjects\Profile\Likes;
use App\Domain\ValueObjects\Profile\ProfileAddress;
use App\Domain\ValueObjects\Profile\ProfileDisplayName;
use App\Domain\ValueObjects\Profile\ProfileFrom;
use App\Domain\ValueObjects\Profile\ProfileGithub;
use App\Domain\ValueObjects\Profile\ProfileId;
use App\Domain\ValueObjects\Profile\ProfileIntroduction;
use App\Domain\ValueObjects\Profile\ProfileJob;
use App\Domain\ValueObjects\Profile\ProfileQiita;
use App\Domain\ValueObjects\Profile\ProfileShortName;
use App\Domain\ValueObjects\Profile\ProfileSummaryIntroduction;
use App\Domain\ValueObjects\Profile\ProfileZenn;
use App\Domain\ValueObjects\Profile\Skill;
use App\Domain\ValueObjects\Profile\Skills;

class ProfileMapper implements ProfileMapperInterface
{
    public function toEntity(ProfileDto $dto): Profile
    {
        return new Profile(
            new ProfileId($dto->id),
            new ProfileAddress($dto->address ?? ''),
            new ProfileDisplayName($dto->displayName ?? ''),
            new ProfileShortName($dto->displayShortName ?? ''),
            new ProfileFrom($dto->from ?? ''),
            new ProfileGithub($dto->github ?? ''),
            new ProfileIntroduction($dto->introduction ?? ''),
            new ProfileJob($dto->job ?? ''),
            new Likes(array_map(fn ($v) => new Like($v), $dto->likes)),
            new ProfileQiita($dto->qiita ?? ''),
            new Skills(array_map(fn ($v) => new Skill($v), $dto->skills)),
            new ProfileSummaryIntroduction($dto->summaryIntroduction ?? ''),
            new ProfileZenn($dto->zenn ?? ''),
        );
    }

    public function toDto(Profile $entity): ProfileDto
    {
        return new ProfileDto(
            id: $entity->id()->value(),
            address: $entity->address()->value(),
            displayName: $entity->displayName()->value(),
            displayShortName: $entity->displayShortName()->value(),
            from: $entity->from()->value(),
            github: $entity->github()->value(),
            introduction: $entity->introduction()->value(),
            job: $entity->job()->value(),
            likes: $entity->likes()->toArray(),
            qiita: $entity->qiita()->value(),
            skills: array_map(fn ($skill) => $skill->value(), $entity->skills()->all()),
            summaryIntroduction: $entity->summaryIntroduction()->value(),
            zenn: $entity->zenn()->value()
        );
    }
}
