<?php

namespace App\Application\UseCases\Profile;

use App\Application\DTOs\ProfileDto;
use App\Domain\Factories\ProfileEntityFactory;
use App\Domain\Repositories\ProfileRepositoryInterface;

/**
 * Profile情報を取得.
 */
class GetProfileUseCase implements GetProfileUseCaseInterface
{
    public function __construct(
        private readonly ProfileRepositoryInterface $repository,
        private readonly ProfileEntityFactory $factory,
    ) {
    }

    public function execute(): ProfileDto
    {
        try {

            $profile = $this->repository->find();

            return $this->factory->toDto($profile);
        } catch (\DomainException $e) {
            throw new \DomainException('プロフィール情報の取得に失敗しました。', 500, $e);
        }
    }
}
