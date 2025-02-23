<?php

namespace App\UseCases\Profile;

use App\Models\Profile;

class DestroyAction
{
    /**
     * Profileデータ削除.
     *
     * @throws \DomainException
     */
    public function __invoke(): int
    {
        $count = Profile::query()->delete();
        if ($count === 0) {
            throw new \DomainException('プロフィールが登録されていません');
        }
        return $count;
    }
}
