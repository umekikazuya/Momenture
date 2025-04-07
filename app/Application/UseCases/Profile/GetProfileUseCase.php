<?php

namespace App\Application\UseCases\Profile;

use App\Domain\Entities\Profile;
use App\Domain\Repositories\ProfileRepositoryInterface;

/**
 * Profile情報を取得.
 */
class GetProfileUseCase implements GetProfileUseCaseInterface
{
    public function __construct(
        private readonly ProfileRepositoryInterface $repository,
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function execute(): Profile
    {
        try {
            $profile = $this->repository->find();

            return $profile;
        } catch (\DomainException $e) {
            throw new \DomainException('プロフィール情報の取得に失敗しました。', 500, $e);
        } catch (\Exception $e) {
            throw new \RuntimeException('DBエラー', $e->getCode(), $e);
        }
    }
}
