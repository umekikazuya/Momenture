<?php

namespace App\Services\Contracts;

use App\Models\Profile;

interface ProfileServiceInterface
{
    public function getProfile(): Profile;

    public function updateProfile(array $attributes): Profile;

    public function deleteProfile(): void;
}
