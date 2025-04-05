<?php

namespace App\Application\UseCases\Profile;

use App\Application\DTOs\ProfileDto;
use App\Application\Mappers\ProfileMapperInterface;
use App\Domain\Repositories\ProfileRepositoryInterface;

/**
 * Profile情報を取得.
 */
class GetProfileUseCase implements GetProfileUseCaseInterface
{
    public function __construct(
        private readonly ProfileRepositoryInterface $repository,
        private readonly ProfileMapperInterface $mapper,
    ) {
    }

    public function execute(): ProfileDto
    {
        try {
            $profile = $this->repository->find();
            return $this->mapper->toDto($profile);
        } catch (\DomainException $e) {
            throw new \DomainException('プロフィール情報の取得に失敗しました。', 500, $e);
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
