<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Profile;

interface ProfileRepositoryInterface
{
    /**
     * プロフィールを取得.
     *
     * @throws \DomainException プロフィールが存在しない場合
     */
    public function find(): Profile;

    /**
     * プロフィールを更新.
     *
     * @throws \DomainException プロフィールが存在しない場合
     * @throws \RuntimeException データベースエラーが発生した場合
     */
    public function update(Profile $profile): Profile;
}
