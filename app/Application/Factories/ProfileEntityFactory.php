<?php

declare(strict_types=1);

namespace App\Domain\Factories;

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

/**
 * ProfileFactoryは、DTOからEntityを作成.
 */
class ProfileEntityFactory
{
    /**
     * DtoからEntityを作成する.
     */
    public static function fromDto(ProfileDto $dto): Profile
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
            new Likes(array_map(fn ($v) => new Like($v), $dto->likes ?? [])),
            new ProfileQiita($dto->qiita ?? ''),
            new Skills(array_map(fn ($v) => new Skill($v), $dto->skills ?? [])),
            new ProfileSummaryIntroduction($dto->summaryIntroduction ?? ''),
            new ProfileZenn($dto->zenn ?? ''),
        );
    }

    /**
     * EntityからDtoを作成する.
     */
    public static function toDto(Profile $profile): ProfileDto
    {
        return new ProfileDto(
            id: $profile->id()->value(),
            address: $profile->address()->value(),
            displayName: $profile->displayName()->value(),
            displayShortName: $profile->displayShortName()->value(),
            from: $profile->from()->value(),
            github: $profile->github()->value(),
            introduction: $profile->introduction()->value(),
            job: $profile->job()->value(),
            likes: $profile->likes()->toArray(),
            qiita: $profile->qiita()->value(),
            skills: array_map(fn ($skill) => $skill->value(), $profile->skills()->all()),
            summaryIntroduction: $profile->summaryIntroduction()->value(),
            zenn: $profile->zenn()->value()
        );
    }
}
