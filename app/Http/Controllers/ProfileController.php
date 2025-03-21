<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\StoreRequest;
use App\Http\Requests\Profile\UpdateRequest;
use App\Http\Resources\ProfileResource;
use App\UseCases\Profile\DestroyAction;
use App\UseCases\Profile\ShowAction;
use App\UseCases\Profile\StoreAction;
use App\UseCases\Profile\UpdateAction;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProfileController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request, StoreAction $action)
    {
        $profile = $request->makeProfile();

        try {
            return new ProfileResource($action($profile));
        } catch (\DomainException $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ShowAction $action)
    {
        try {
            return new ProfileResource($action());
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, UpdateAction $update_action, ShowAction $show_action)
    {
        try {
            return new ProfileResource($update_action($show_action(), $request->validated()));
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyAction $action)
    {
        try {
            return response()->json(
                [
                'message' => 'プロフィールが削除されました',
                'count' => $action(),
                ], 200
            );
        } catch (\DomainException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}
