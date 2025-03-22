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
    /**
     * コンストラクタ
     *
     * このコンストラクタは、注目記事の全件取得、記事の割り当て、非活性化、優先度変更に対応するユースケースを注入し、
     * コントローラーの機能を提供するための依存性を初期化します。
     */
    public function __construct(
        private FindAllUseCaseInterface $findAllUseCase,
        private AssignArticleUseCaseInterface $assignArticleUseCase,
        private DeactivateUseCaseInterface $deactivateUseCase,
        private ChangePriorityUseCaseInterface $changePriorityUseCase
    ) {
    }

    /**
     * 全ての注目記事を取得し、リソースコレクションとして返却する。
     *
     * このメソッドは、依存性注入された use case を用いて全ての注目記事を取得し、
     * その結果を FeaturedArticleResource インスタンスのコレクションに変換して返します。
     *
     * @return AnonymousResourceCollection 変換された注目記事リソースのコレクション
     */
    public function index(): AnonymousResourceCollection
    {
        try {
            $entities = $this->findAllUseCase->handle();
            return FeaturedArticleResource::collection($entities);
        } catch (\RuntimeException $e) {
            abort(500, $e->getMessage());
        }
    }

    /**
     * リクエストから注目記事の情報を取得し、新規に注目記事を作成・割り当てします。
     *
     * HTTPリクエストから取得した記事IDと優先度を用いて、注目記事作成のユースケースを実行し、
     * 作成された注目記事をリソースとして返します。なお、DomainException発生時はHTTP 409で、
     * その他の例外発生時はHTTP 200で中断します。
     *
     * @param StoreRequest $request 記事の割り当てに必要な入力（記事IDと優先度）を含むHTTPリクエスト。
     *
     * @return FeaturedArticleResource 作成された注目記事リソースを返します。
     */
    public function store(StoreRequest $request): FeaturedArticleResource
    {
        try {
            $entity = $this->assignArticleUseCase->handle(
                id: new FeaturedArticleId((int) $request->input('article_id')),
                priority: new FeaturedPriority((int) $request->input('priority')),
            );
            return new FeaturedArticleResource($entity);
        } catch (\DomainException $e) {
            abort(409, $e->getMessage());
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    /**
     * 指定された注目記事の優先度を変更する。
     *
     * リクエストから取得した優先度に基づき、指定されたIDの注目記事の優先度を更新します。
     * 正常に処理が完了した場合はコンテンツなしのレスポンス（HTTP 204）を返し、
     * ドメイン制約に違反した場合は HTTP 409 エラーで処理を中断します。
     *
     * @param  ChangePriorityRequest $request 優先度変更情報を含むリクエスト
     * @param  int                   $id      変更対象の注目記事の識別子
     * @return Response コンテンツなしのレスポンス（HTTP 204）
     */
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

    /**
     * 指定されたIDの注目記事を非アクティブ化する。
     *
     * 指定された記事IDに基づき、注目記事の非アクティブ化処理を実行します。
     * 成功時にはコンテンツなしのレスポンスを返し、ドメイン例外が発生した場合はHTTP 409ステータスで中断されます。
     *
     * @param  int $id 非アクティブ化する注目記事のID。
     * @return Response コンテンツなしのレスポンス。
     */
    public function deactivate(int $id): Response
    {
        try {
            $this->deactivateUseCase->handle(
                id: new FeaturedArticleId($id)
            );
            return response()->noContent();
        } catch (\DomainException $e) {
            abort(409, $e->getMessage());
        }
    }
}
