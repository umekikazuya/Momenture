<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Application\DTOs\CreateArticleInput;
use App\Application\DTOs\UpdateArticleInput;
use App\Application\UseCases\Article\ChangeArticleStatusUseCaseInterface;
use App\Application\UseCases\Article\CreateArticleUseCaseInterface;
use App\Application\UseCases\Article\DeleteArticleUseCaseInterface;
use App\Application\UseCases\Article\FindArticleByIdUseCaseInterface;
use App\Application\UseCases\Article\FindArticlesUseCaseInterface;
use App\Application\UseCases\Article\RestoreArticleUseCaseInterface;
use App\Application\UseCases\Article\UpdateArticleUseCaseInterface;
use App\Http\Requests\Article\ChangeStatusRequest;
use App\Http\Requests\Article\SearchRequest;
use App\Http\Requests\Article\ShowRequest;
use App\Http\Requests\Article\StoreRequest;
use App\Http\Requests\Article\UpdateRequest;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    /**
     * ArticleController の依存性注入を行うコンストラクタ。
     *
     * 記事の作成、更新、削除、復元、個別取得、一覧取得、及びステータス変更の各ユースケースを注入します。
     */
    public function __construct(
        private CreateArticleUseCaseInterface $createArticle,
        private UpdateArticleUseCaseInterface $updateArticle,
        private DeleteArticleUseCaseInterface $deleteArticle,
        private RestoreArticleUseCaseInterface $restoreArticle,
        private FindArticleByIdUseCaseInterface $findArticleById,
        private FindArticlesUseCaseInterface $findArticles,
        private ChangeArticleStatusUseCaseInterface $changeArticleStatus,
    ) {
    }

    /**
     * 新しい記事を作成し、その記事のリソースを返す。
     *
     * StoreRequest から入力データを抽出し、CreateArticleInput を作成した後、依存する createArticle ユースケースを実行して記事を作成します。
     *
     * @param StoreRequest $request 記事作成に必要なリクエストデータを含むオブジェクト
     * @return ArticleResource 作成された記事を表現するリソース
     */
    public function store(StoreRequest $request): ArticleResource
    {
        $input = CreateArticleInput::fromRequest($request);
        $article = $this->createArticle->execute($input);

        return (new ArticleResource($article));
    }

    /**
     * 指定された記事IDの記事情報を更新し、更新後の情報をArticleResourceとして返却する。
     *
     * リクエストから入力データをDTOに変換し、更新ユースケースを実行して記事を更新します。
     *
     * @param int $id 更新対象の記事ID
     * @param UpdateRequest $request 更新に必要なデータを含むリクエスト
     * @return ArticleResource 更新された記事のリソース表現
     */
    public function update(int $id, UpdateRequest $request): ArticleResource
    {
        $input = UpdateArticleInput::fromRequest($id, $request);
        $article = $this->updateArticle->execute($input);

        return new ArticleResource($article);
    }

    /**
     * 指定された記事IDに対し、リクエストの「force」パラメータに基づいて記事を削除する。
     *
     * リクエストに含まれる「force」パラメータがtrueの場合は完全削除、falseまたは未指定の場合はソフトデリートを実施する。
     * 削除処理完了後、コンテンツなしのHTTPレスポンスを返す。
     *
     * @param int $id 記事の識別子
     *
     * @return Response コンテンツなしのHTTPレスポンス
     */
    public function destroy(int $id, Request $request): Response
    {
        $force = $request->boolean('force', false);
        $this->deleteArticle->execute($id, $force);

        return response()->noContent();
    }

    /**
     * 指定された記事を復元する。
     *
     * 渡された記事IDに基づいて削除済みの記事を復元し、復元処理が成功した場合、HTTPステータス204 (No Content) のレスポンスを返します。
     *
     * @param int $id 復元対象の記事ID
     *
     * @return Response 復元成功時のNo Contentレスポンス
     */
    public function restore(int $id): Response
    {
        $this->restoreArticle->execute($id);

        return response()->noContent();
    }

    /**
     * 指定された記事IDに対応する記事の詳細情報を取得し、ArticleResourceとして返す。
     *
     * このメソッドは、findArticleByIdユースケースを実行して対象記事を取得し、その結果をArticleResourceにラップして返します。
     *
     * @param int $id 取得対象の記事ID
     * @return ArticleResource 取得した記事の詳細情報を含むリソース
     */
    public function show(ShowRequest $request, int $id): ArticleResource
    {
        $article = $this->findArticleById->execute($id);

        return new ArticleResource($article);
    }

    /**
     * 記事一覧および検索結果を取得する。
     *
     * リクエストに含まれる検索条件（status, service_id, tag_id）、ソート順、ページ番号およびページ当たりの件数を元に記事を検索し、ArticleResource のコレクションとして返します。
     *
     * @param SearchRequest $request HTTPリクエスト。記事のフィルタリング条件とページネーション情報を含む。
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection 記事リソースのコレクション
     */
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

    /**
     * 記事の公開状態を変更する。
     *
     * リクエストから取得した新しい公開状態を用いて、指定された記事の状態を更新する。
     * 処理が正常に完了すると、内容なしのHTTPレスポンスを返す。
     *
     * @param ChangeStatusRequest $request リクエストデータ。new_status プロパティに更新後の状態が設定されている。
     * @param int $id 更新対象の記事のID。
     * @return Response 状態変更完了後の内容なしHTTPレスポンス。
     */
    public function changeStatus(ChangeStatusRequest $request, int $id): Response
    {
        $this->changeArticleStatus->execute($id, $request->new_status);

        return response()->noContent();
    }
}
