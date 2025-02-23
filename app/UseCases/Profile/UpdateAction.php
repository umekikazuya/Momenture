<?php

namespace App\UseCases\Profile;

use App\Models\Profile;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateAction
{
    /**
     * Profileデータ更新.
     *
     * Profile情報の登録がない場合は新規登録.
     */
    public function __invoke(Profile $profile, array $attributes): Profile
    {
        if (! $profile->exists) {
            throw new ModelNotFoundException('プロフィールが登録されていません');
        }

        $profile->fill($attributes);
        $profile->save();

        return $profile;
    }
}
