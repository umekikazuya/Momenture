<?php

declare(strict_types=1);

namespace App\Application\UseCases\Profile;

use App\Application\DTOs\ProfileDto;
use App\Domain\Entities\Profile;

/**
 * Profile情報を更新.
 */
interface UpdateProfileUseCaseInterface
{
    /**
     * Profile情報を更新.
     *
     * @param ProfileDto $dto 更新対象のDTO
     *
     * @return Profile 更新後のProfileエンティティ
     *
     * @throws \DomainException 無効なデータが渡された場合
     * @throws \RuntimeException データベース接続エラーや保存失敗時など、実行時に発生する可能性のあるエラー
     */
    public function execute(ProfileDto $dto): Profile;
}
