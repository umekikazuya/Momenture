<?php

namespace App\Http\Controllers;

use App\Services\Contracts\ProfileServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected ProfileServiceInterface $profileService;

    public function __construct(ProfileServiceInterface $profileService)
    {
        $this->profileService = $profileService;
    }

    /**
     * プロフィールの表示
     */
    public function show(): JsonResponse
    {
        $profile = $this->profileService->getProfile();

        return response()->json($profile);
    }

    /**
     * プロフィールの更新
     */
    public function update(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'displayName' => 'nullable|string|max:255',
            'introduction' => 'nullable|string',
            'likes' => 'nullable|array',
            'likes.*' => 'string',
        ]);

        $profile = $this->profileService->updateProfile($validatedData);

        return response()->json($profile);
    }

    /**
     * プロフィールの削除
     */
    public function destroy(): JsonResponse
    {
        $this->profileService->deleteProfile();

        return response()->json(['message' => 'Profile deleted successfully.']);
    }
}
