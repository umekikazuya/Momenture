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
     * 記事関連の各ユースケースインターフェースを注入し、コントローラの依存性を初期化するコンストラクタ。
     *
     * 本コンストラクタは、記事の作成、更新、削除、復元、ID検索、複数記事検索、およびステータス変更を担当する各ユースケースを注入します。
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
     * 受け取ったリクエストから記事を作成し、作成された記事リソースを返します。
     *
     * StoreRequestからCreateArticleInputを生成し、記事作成ユースケースを実行して新規記事を作成します。
     * その後、作成済み記事をArticleResourceでラップして返却します。
     *
     * @param StoreRequest $request 記事作成に必要なデータを含むリクエスト
     * @return ArticleResource 作成された記事を表すリソース
     */
    public function store(StoreRequest $request): ArticleResource
    {
        $input = CreateArticleInput::fromRequest($request);
        $article = $this->createArticle->execute($input);

        return (new ArticleResource($article));
    }

    /**
     * 指定された記事IDと更新リクエストに基づいて記事を更新する。
     *
     * 更新内容は UpdateArticleInput に変換され、更新処理が実行されます。
     * 更新後の記事は ArticleResource として返されます。
     *
     * @param int $id 更新対象の記事の一意なID。
     * @param UpdateRequest $request 更新内容を含むリクエストオブジェクト。
     * @return ArticleResource 更新後の記事データをラップしたリソースオブジェクト。
     */
    public function update(int $id, UpdateRequest $request): ArticleResource
    {
        $input = UpdateArticleInput::fromRequest($id, $request);
        $article = $this->updateArticle->execute($input);

        return new ArticleResource($article);
    }

    /**
     * 指定された記事IDの記事を削除する。
     *
     * リクエストの "force" パラメータが true の場合は完全削除、false または未指定の場合はソフトデリートを実行する。
     *
     * @param int $id 削除対象の記事ID。
     * @return Response HTTP 204 No Content のレスポンスを返す。
     */
    public function destroy(int $id, Request $request): Response
    {
        $force = $request->boolean('force', false);
        $this->deleteArticle->execute($id, $force);

        return response()->noContent();
    }

    /**
     * 指定した記事IDの削除済み記事を復元する。
     *
     * 指定されたIDに対応する記事の復元処理を実行し、ボディのないHTTPレスポンス（204 No Content）を返します。
     *
     * @param int $id 復元する記事のID
     * @return Response ボディなしのレスポンス
     */
    public function restore(int $id): Response
    {
        $this->restoreArticle->execute($id);

        return response()->noContent();
    }

    /**
     * 指定された記事IDに基づいて記事の詳細を取得し、ArticleResourceオブジェクトとして返却する。
     *
     * このメソッドは、findArticleByIdユースケースを用いて記事情報を取得し、
     * その結果をArticleResourceにラップしてレスポンスとする。
     *
     * @param ShowRequest $request リクエスト情報を保持するShowRequestインスタンス
     * @param int $id 取得対象の記事の一意な識別子
     *
     * @return ArticleResource 取得された記事詳細を含むリソースオブジェクト
     */
    public function show(ShowRequest $request, int $id): ArticleResource
    {
        $article = $this->findArticleById->execute($id);

        return new ArticleResource($article);
    }

    /**
     * 記事一覧および検索結果を取得し、ArticleResourceのコレクションとして返却する。
     *
     * リクエストから抽出した検索条件（状態、サービスID、タグID）に加え、並び順とページネーションの情報を利用して記事一覧を取得する。
     *
     * @param SearchRequest $request 検索条件、並び順、ページ番号、1ページ当たりの件数を含むリクエスト
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection 取得した記事のリソースコレクション
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
     * 指定された記事IDに対し、リクエストで指定された新しい公開状態に更新します。
     * 更新処理完了後、内容のないHTTPレスポンスを返します。
     *
     * @param ChangeStatusRequest $request 新しい公開状態を含むリクエスト。
     * @param int $id 公開状態を変更する対象記事のID。
     * @return Response 空のHTTPレスポンス。
     */
    public function changeStatus(ChangeStatusRequest $request, int $id): Response
    {
        $this->changeArticleStatus->execute($id, $request->new_status);

        return response()->noContent();
    }
}
