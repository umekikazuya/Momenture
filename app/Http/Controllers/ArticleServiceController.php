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
    /**
     * ArticleServiceControllerのインスタンスを初期化します。
     *
     * 記事サービスの作成、更新、削除、及び取得に必要なユースケースインターフェースを注入します。
     */
    public function __construct(
        private CreateUseCaseInterface $create,
        private UpdateUseCaseInterface $update,
        private DeleteUseCaseInterface $delete,
        private FindByIdUseCaseInterface $findById,
        private FindAllUseCaseInterface $findAll,
    ) {
    }

    /**
     * 記事サービスを新規作成し、そのリソースを返却します。
     *
     * 入力リクエストから記事サービスの名称を取得し、作成用ユースケースを実行して新しい記事サービスを生成します。
     *
     * @param  StoreRequest  $request  作成に必要なリクエスト。記事サービスの名称情報を含みます。
     * @return ArticleServiceResource 作成された記事サービスのリソース。
     */
    public function store(StoreRequest $request): ArticleServiceResource
    {
        $entity = $this->create->execute($request->name);

        return new ArticleServiceResource($entity);
    }

    /**
     * 記事サービスを更新する。
     *
     * 指定されたIDの記事サービスの名前を、リクエストに含まれる情報に基づいて更新します。
     * 更新はアップデート用ユースケースを介して実行され、処理結果は更新後の記事サービス情報を含むリソースとして返されます。
     *
     * @param  int  $id  更新対象の記事サービスの識別子。
     * @param  UpdateRequest  $request  更新情報を含むリクエストインスタンス。
     * @return ArticleServiceResource 更新後の記事サービス情報を保持するリソース。
     */
    public function update(int $id, UpdateRequest $request): ArticleServiceResource
    {
        try {
            $entity = $this->update->execute(
                new ArticleService(
                    id: new ArticleServiceId($id),
                    name: new ArticleServiceName($request->name),
                )
            );
            return new ArticleServiceResource($entity);
        } catch (\DomainException $e) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, $e->getMessage());
        }
    }

    /**
     * 指定された記事サービスIDの削除を実行します（ソフトデリートまたは完全削除）。
     *
     * リクエストから "force" パラメータを取得し、true の場合は完全削除、false の場合はソフトデリートを行います。
     * 削除処理完了後、HTTP 204 (No Content) のレスポンスを返します。
     *
     * @param  int  $id  削除対象の記事サービスのID
     * @param  DeleteRequest  $request  削除リクエスト。'force' フラグで削除方法を指定
     * @return Response HTTP 204 No Content レスポンス
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException 記事サービスの削除中にエラーが発生した場合
     */
    public function destroy(int $id, DeleteRequest $request): Response
    {
        $force = $request->boolean('force', false);
        try {
            $this->delete->execute($id, $force);

            return response()->noContent();
        } catch (\DomainException $e) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, $e->getMessage());
        } catch (\RuntimeException $e) {
            abort(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * 指定された記事サービスIDに対応する記事サービスの詳細情報を取得する。
     *
     * 指定のIDで記事サービスを検索し、存在しない場合はHTTP 404エラーで中断します。存在する場合は、その詳細情報を含むリソースを返却します。
     *
     * @param  int  $entityId  取得対象のサービスID
     * @return ArticleServiceResource 記事サービスの詳細情報を含むリソース
     */
    public function show(ShowRequest $request, int $entityId): ArticleServiceResource
    {
        $entity = $this->findById->execute($entityId);

        if ($entity === null) {
            abort(Response::HTTP_NOT_FOUND, 'サービスが見つかりませんでした。');
        }

        return new ArticleServiceResource($entity);
    }

    /**
     * 登録されている全記事サービスの一覧を取得し、リソースコレクションとして返却します。
     *
     * すべての記事サービスを取得し、その一覧を ArticleServiceResource のコレクションに変換して返します。
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection 記事サービスリソースのコレクション
     */
    public function index(FormRequest $request)
    {
        $entities = $this->findAll->execute();

        return ArticleServiceResource::collection($entities);
    }
}
