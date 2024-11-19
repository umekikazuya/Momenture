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
            'displayShortName' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'from' => 'nullable|string|max:255',
            'github' => 'nullable|string|max:255',
            'introduction' => 'nullable|string',
            'job' => 'nullable|string|max:255',
            'likes' => 'nullable|array',
            'likes.*' => 'string|max:50',
            'qiita' => 'nullable|string|max:255',
            'skills' => 'nullable|array',
            'skills.*' => 'string|max:50',
            'summaryIntroduction' => 'nullable|string|max:500',
            'zenn' => 'nullable|string|max:255',
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
