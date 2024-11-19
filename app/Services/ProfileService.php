<?php

namespace App\Services;

use App\Models\Profile;
use App\Repositories\Contracts\ProfileRepositoryInterface;
use App\Services\Contracts\ProfileServiceInterface;

class ProfileService implements ProfileServiceInterface
{
    protected ProfileRepositoryInterface $repository;

    public function __construct(ProfileRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getProfile(): Profile
    {
        $profile = $this->repository->findById('PROFILE#1');
        if (! $profile) {
            $profile = new Profile([]);
            $this->repository->save($profile);
        }

        return $profile;
    }

    public function updateProfile(array $attributes): Profile
    {
        $profile = $this->getProfile();
        $profile->update($attributes);
        $this->repository->save($profile);

        return $profile;
    }

    public function deleteProfile(): void
    {
        $this->repository->delete('PROFILE#1');
    }
}
