<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Application\UseCases\FeaturedArticle\AssignArticleUseCaseInterface;
use App\Application\UseCases\FeaturedArticle\ChangePriorityUseCaseInterface;
use App\Application\UseCases\FeaturedArticle\DeactivateUseCaseInterface;
use App\Application\UseCases\FeaturedArticle\FindAllUseCaseInterface;
use App\Domain\ValueObjects\FeaturedArticleId;
use App\Domain\ValueObjects\FeaturedPriority;
use App\Http\Requests\FeaturedArticle\ChangePriorityRequest;
use App\Http\Requests\FeaturedArticle\StoreRequest;
use App\Http\Resources\FeaturedArticleResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class FeaturedArticleController extends Controller
{
    public function __construct(
        private FindAllUseCaseInterface $findAllUseCase,
        private AssignArticleUseCaseInterface $assignArticleUseCase,
        private DeactivateUseCaseInterface $deactivateUseCase,
        private ChangePriorityUseCaseInterface $changePriorityUseCase
    )
    {
    }

    public function index(): AnonymousResourceCollection
    {
        $entities = $this->findAllUseCase->handle();

        return FeaturedArticleResource::collection($entities);
    }

    public function store(StoreRequest $request): FeaturedArticleResource
    {
        try {
            $entity = $this->assignArticleUseCase->handle(
                new FeaturedArticleId((int) $request->input('article_id')),
                new FeaturedPriority((int) $request->input('priority')),
            );
            return new FeaturedArticleResource($entity);
        } catch (\DomainException $e) {
            abort(409, $e->getMessage());
        } catch (\Exception $e) {
            abort(200, $e->getMessage());
        }
    }

    public function changePriority(ChangePriorityRequest $request, int $id): Response
    {
        try {
            $this->changePriorityUseCase->handle(
                id: new FeaturedArticleId($id),
                priority: new FeaturedPriority((int) $request->input('priority'))
            );

            return response()->noContent();
        } catch (\DomainException $e) {
            abort(409, $e->getMessage());
        }
    }

    public function deactivate(int $id): Response
    {
        try {
            $this->deactivateUseCase->handle(new FeaturedArticleId($id));

            return response()->noContent();
        } catch (\DomainException $e) {
            abort(409, $e->getMessage());
        }
    }
}
