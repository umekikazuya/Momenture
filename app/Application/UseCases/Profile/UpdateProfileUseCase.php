<?php

namespace App\Application\UseCases\Profile;

use App\Application\DTOs\ProfileDto;
use App\Application\Mappers\ProfileMapperInterface;
use App\Domain\Repositories\ProfileRepositoryInterface;

class UpdateProfileUseCase implements UpdateProfileUseCaseInterface
{
    public function __construct(
        private readonly ProfileRepositoryInterface $repository,
        private readonly ProfileMapperInterface $mapper,
    ) {}

    public function execute(ProfileDto $dto): void
    {
        try {
            $profile = $this->mapper->toEntity($dto);
            $this->repository->update($profile);
        } catch (\DomainException $e) {
            throw new \DomainException('プロフィール情報の更新に失敗しました。', 500, $e);
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
