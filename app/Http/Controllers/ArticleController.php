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
     * ArticleController のインスタンスを初期化し、記事管理に必要な各ユースケースを依存性注入します。
     *
     * 各記事操作（作成、更新、削除、復元、詳細取得、一覧検索、ステータス変更）に対応するユースケースを受け取り、
     * コントローラー内での処理に活用します。
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
     * 新しい記事を作成し、ArticleResource形式で返却します。
     *
     * このメソッドは、StoreRequestからCreateArticleInputを生成し、記事作成ユースケースを実行することで
     * 新規記事を作成します。生成された記事はArticleResourceにラップされて返されます。
     *
     * @param StoreRequest $request 新規記事作成に必要なリクエストデータ
     * @return ArticleResource 作成された記事のリソース
     */
    public function store(StoreRequest $request): ArticleResource
    {
        $input = CreateArticleInput::fromRequest($request);
        $article = $this->createArticle->execute($input);

        return (new ArticleResource($article));
    }

    /**
     * 指定された記事IDに基づいて記事を更新する。
     *
     * 与えられた更新リクエストから更新情報を生成し、記事更新ユースケースを実行して記事を更新します。
     * 更新後の記事はArticleResourceとして返されます。
     *
     * @param int $id 更新対象の記事のID
     * @param UpdateRequest $request 更新データを含むリクエスト
     * @return ArticleResource 更新された記事をラップしたリソース
     */
    public function update(int $id, UpdateRequest $request): ArticleResource
    {
        $input = UpdateArticleInput::fromRequest($id, $request);
        $article = $this->updateArticle->execute($input);

        return new ArticleResource($article);
    }

    /**
     * 記事を削除する。（ソフトデリート／完全削除）
     *
     * HTTPリクエスト内の 'force' パラメータに基づき、ソフトデリートまたは完全削除を実施します。
     * 'force' が true の場合は完全削除、false または未指定の場合はソフトデリートを行います。
     *
     * @param int $id 削除対象の記事の識別子。
     * @param Request $request HTTPリクエスト。'force' フラグで削除方式を指定します。
     *
     * @return Response 削除処理の結果として no content レスポンスを返します。
     */
    public function destroy(int $id, Request $request): Response
    {
        $force = $request->boolean('force', false);
        $this->deleteArticle->execute($id, $force);

        return response()->noContent();
    }

    /**
     * 指定されたIDの記事を復元する。
     *
     * 削除済みの記事を指定されたIDに基づいて復元し、操作が成功した場合はHTTP No Contentレスポンスを返します。
     *
     * @param int $id 復元対象の記事ID。
     * @return Response HTTP No Contentレスポンス。
     */
    public function restore(int $id): Response
    {
        $this->restoreArticle->execute($id);

        return response()->noContent();
    }

    /**
     * 指定されたIDの記事詳細情報を取得し、ArticleResourceとして返却する。
     *
     * 提供されたShowRequestと記事IDに基づいて対象記事の詳細情報を取得し、その情報をArticleResourceにラップして返します。
     *
     * @param ShowRequest $request リクエストオブジェクト。記事取得に必要な検証済みデータを含みます。
     * @param int $id 取得対象の記事の一意なID。
     * @return ArticleResource 取得した記事詳細情報をラップしたリソースオブジェクト。
     */
    public function show(ShowRequest $request, int $id): ArticleResource
    {
        $article = $this->findArticleById->execute($id);

        return new ArticleResource($article);
    }

    /**
     * 指定された検索条件に基づいて記事一覧を取得し、リソースコレクションとして返す。
     *
     * リクエストオブジェクトから、記事の状態、サービスID、タグIDに加え、並び順、ページ番号、表示件数の情報を抽出し、
     * それらの条件で記事取得ユースケースを実行します。返却される記事は ArticleResource のコレクションとしてラップされます。
     *
     * @param SearchRequest $request 検索条件を含むリクエスト。'status', 'service_id', 'tag_id' および 'sort'（デフォルト: 'created_at_desc'）、'page'（デフォルト: 1）、'per_page'（デフォルト: 10）の情報を含む。
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection 取得した記事リソースのコレクション
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
     * 指定された記事IDに対して、リクエスト内の新しい公開状態で更新処理を実行する。
     * 更新に成功すると、内容のないHTTPレスポンスを返す。
     *
     * @param ChangeStatusRequest $request 新しい公開状態を含むリクエストオブジェクト
     * @param int $id 公開状態を変更する対象の記事のID
     * @return Response 内容のないレスポンス
     */
    public function changeStatus(ChangeStatusRequest $request, int $id): Response
    {
        $this->changeArticleStatus->execute($id, $request->new_status);

        return response()->noContent();
    }
}
