<?php

namespace App\Http\Controllers;

use App\Application\UseCases\Profile\GetProfileUseCaseInterface;
use App\Application\UseCases\Profile\UpdateProfileUseCaseInterface;
use App\Http\Requests\Profile\UpdateRequest;
use App\Http\Resources\ProfileResource;

class ProfileController extends Controller
{
    public function __construct(
        private readonly GetProfileUseCaseInterface $getProfile,
        private readonly UpdateProfileUseCaseInterface $updateProfile
    ) {}

    /**
     * Display the specified resource.
     */
    public function show()
    {
        try {
            return new ProfileResource(
                $this->getProfile->execute()
            );
        } catch (\DomainException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        } catch (\RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request)
    {
        try {
            return new ProfileResource(
                $this->updateProfile->execute($request->toDto())
            );
        } catch (\DomainException $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        } catch (\RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
