<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Entities\Profile;

interface ProfileRepositoryInterface
{
    /**
     * プロフィールを取得する
     *
     * @throws \DomainException プロフィールが見つからない場合
     * @throws \RuntimeException データベース操作で例外が発生した場合
     */
    public function find(): Profile;

    /**
     * プロフィールを保存する
     *
     * @throws \RuntimeException データベース操作で例外が発生した場合
     */
    public function update(Profile $profile): Profile;
}
