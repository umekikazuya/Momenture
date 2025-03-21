<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Application\UseCases\ArticleService\CreateUseCaseInterface;
use App\Application\UseCases\ArticleService\DeleteUseCaseInterface;
use App\Application\UseCases\ArticleService\FindAllUseCaseInterface;
use App\Application\UseCases\ArticleService\FindByIdUseCaseInterface;
use App\Application\UseCases\ArticleService\UpdateUseCaseInterface;
use App\Domain\Entities\ArticleService;
use App\Domain\ValueObjects\ArticleServiceId;
use App\Domain\ValueObjects\ArticleServiceName;
use App\Http\Requests\ArticleService\DeleteRequest;
use App\Http\Requests\ArticleService\ShowRequest;
use App\Http\Requests\ArticleService\StoreRequest;
use App\Http\Requests\ArticleService\UpdateRequest;
use App\Http\Resources\ArticleServiceResource;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class ArticleServiceController extends Controller
{
    public function __construct(
        private CreateUseCaseInterface $create,
        private UpdateUseCaseInterface $update,
        private DeleteUseCaseInterface $delete,
        private FindByIdUseCaseInterface $findById,
        private FindAllUseCaseInterface $findAll,
    ) {
    }

    // 記事サービス作成
    public function store(StoreRequest $request): ArticleServiceResource
    {
        $articleService = $this->create->execute($request->name);

        return new ArticleServiceResource($articleService);
    }

    // 記事サービス更新
    public function update(int $id, UpdateRequest $request): ArticleServiceResource
    {
        $articleService = $this->update->execute(
            new ArticleService(
                id: new ArticleServiceId($id),
                name: new ArticleServiceName($request->name),
            )
        );

        return new ArticleServiceResource($articleService);
    }

    // 記事サービス削除（ソフトデリート／完全削除）
    public function destroy(int $id, DeleteRequest $request): Response
    {
        $force = $request->boolean('force', false);
        $this->delete->execute($id, $force);

        return response()->noContent();
    }

    // 記事サービス詳細取得
    public function show(ShowRequest $request, int $articleServiceId): ArticleServiceResource
    {
        $articleService = $this->findById->execute($articleServiceId);

        if ($articleService === null) {
            abort(Response::HTTP_NOT_FOUND, 'サービスが見つかりませんでした。');
        }

        return new ArticleServiceResource($articleService);
    }

    // 記事サービス一覧取得
    public function index(FormRequest $request)
    {
        $articleServices = $this->findAll->execute();

        return ArticleServiceResource::collection($articleServices);
    }
}
