<?php

namespace App\UseCases\Profile;

use App\Models\Profile;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ShowAction
{
    /**
     * ProfileModelの取得.
     *
     * @throws ModelNotFoundException
     */
    public function __invoke(): Profile
    {
        $profile = Profile::query()->first();
        if (! assert($profile->exists)) {
            throw new ModelNotFoundException('プロフィールが登録されていません');
        }

        return $profile;
    }
}
