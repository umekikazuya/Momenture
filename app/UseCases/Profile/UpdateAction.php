<?php

namespace App\UseCases\Profile;

use App\Http\Requests\Profile\UpdateRequest;
use App\Models\Profile;

class UpdateAction
{
    /**
     * Profileデータ更新.
     */
    public function handle(string $id, UpdateRequest $request): Profile
    {
        $profile = Profile::findOrFail($id);
        $profile->fill($request->validated());
        $profile->save();

        return $profile;
    }
}
