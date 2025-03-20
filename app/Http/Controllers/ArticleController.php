<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Application\UseCases\Article\ChangeArticleStatusUseCaseInterface;
use App\Application\UseCases\Article\CreateArticleUseCaseInterface;
use App\Application\UseCases\Article\DeleteArticleUseCaseInterface;
use App\Application\UseCases\Article\FindArticleByIdUseCaseInterface;
use App\Application\UseCases\Article\FindArticlesUseCaseInterface;
use App\Application\UseCases\Article\RestoreArticleUseCaseInterface;
use App\Application\UseCases\Article\UpdateArticleUseCaseInterface;
use App\Http\Requests\Article\ChangeStatusRequest;
use App\Http\Requests\Article\ShowRequest;
use App\Http\Requests\Article\StoreRequest;
use App\Http\Requests\Article\UpdateRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    public function __construct(
        private CreateArticleUseCaseInterface $createArticle,
        private UpdateArticleUseCaseInterface $updateArticle,
        private DeleteArticleUseCaseInterface $deleteArticle,
        private RestoreArticleUseCaseInterface $restoreArticle,
        private FindArticleByIdUseCaseInterface $findArticleById,
        private FindArticlesUseCaseInterface $findArticles,
        private ChangeArticleStatusUseCaseInterface $changeArticleStatus,
    ) {}

    // 記事作成
    public function store(StoreRequest $request): ArticleResource
    {
        $article = $this->createArticle->execute(
            $request->title,
            $request->link,
            $request->status,
            $request->service
        );

        return new ArticleResource($article);
    }

    // 記事更新
    public function update(UpdateRequest $request, int $id): ArticleResource
    {
        $article = $this->updateArticle->execute(
            $id,
            $request->title,
            $request->link,
            $request->service
        );

        return new ArticleResource($article);
    }

    // 記事削除（ソフトデリート／完全削除）
    public function destroy(int $id, Request $request): Response
    {
        $force = $request->boolean('force', false);
        $this->deleteArticle->execute($id, $force);

        return response()->noContent();
    }

    // 記事復元
    public function restore(int $id): Response
    {
        $this->restoreArticle->execute($id);

        return response()->noContent();
    }

    // 記事詳細取得
    public function show(ShowRequest $request, int $id): ArticleResource
    {
        $article = $this->findArticleById->execute($id);

        return new ArticleResource($article);
    }

    // 記事一覧・検索取得
    public function index(SearchRequest $request)
    {
        $articles = $this->findArticles->execute(
            $request->only(['status', 'service_id', 'tag_id']),
            $request->get('sort', 'created_at_desc'),
            (int) $request->get('page', 1),
            (int) $request->get('per_page', 10)
        );

        return ArticleResource::collection($articles);
    }

    // 公開状態変更
    public function changeStatus(ChangeStatusRequest $request, int $id): Response
    {
        $this->changeArticleStatus->execute($id, $request->new_status);

        return response()->noContent();
    }
}
