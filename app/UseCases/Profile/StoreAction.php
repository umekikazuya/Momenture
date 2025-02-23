<?php

namespace App\UseCases\Profile;

use App\Models\Profile;

class StoreAction
{
    /**
     * Profileデータ作成.
     *
     * @throws \DomainException
     */
    public function __invoke(Profile $profile): Profile
    {
        asset($profile->exists);

        if ($profile->query()->get()->count() >= 1) {
            throw new \DomainException('Profileデータは既に登録されています。');
        }

        $profile->save();
        return $profile;
    }
}
