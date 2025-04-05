<?php

declare(strict_types=1);

namespace App\Application\Assemblers;

use App\Application\DTOs\ProfileDto;
use App\Domain\Entities\Profile;

/**
 * ProfileEntityをDTOに変換.
 */
class ProfileAssembler
{
    /**
     * プロフィールをDTOに変換.
     *
     * @param  Profile $profile
     * @return ProfileDto
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
            skills: $profile->skills()->all(),
            summaryIntroduction: $profile->summaryIntroduction()->value(),
            zenn: $profile->zenn()->value(),
        );
    }
}
