<?php

namespace App\Application\UseCases\Profile;

use App\Application\DTOs\ProfileDto;
use App\Domain\Factories\ProfileEntityFactory;
use App\Domain\Repositories\ProfileRepositoryInterface;

class UpdateProfileUseCase implements UpdateProfileUseCaseInterface
{
    public function __construct(
        private readonly ProfileRepositoryInterface $repository,
        private readonly ProfileEntityFactory $factory,
    ) {
    }

    public function execute(ProfileDto $dto): void
    {
        try {
            $profile = $this->factory->fromDto($dto);
            $this->repository->save($profile);
        } catch (\Throwable $e) {
            throw new \DomainException('プロフィールの更新に失敗しました。', 500, $e);
        }
    }
}
