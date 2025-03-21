<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\ArticleService;
use App\Domain\Repositories\ArticleServiceRepositoryInterface;
use App\Domain\ValueObjects\ArticleServiceId;
use App\Domain\ValueObjects\ArticleServiceName;
use App\Models\ArticleService as ArticleServiceModel;

class EloquentArticleServiceRepository implements ArticleServiceRepositoryInterface
{
    /**
     * 指定されたIDに対応するArticleServiceエンティティを返します。
     *
     * 指定されたIDを元にArticleServiceModelを検索し、モデルが存在する場合はそれをArticleServiceエンティティに変換して返します。存在しない場合はnullを返します。
     *
     * @param int $id 取得対象のArticleServiceのID
     *
     * @return ArticleService|null 対応するArticleServiceエンティティ、または該当するエンティティが存在しない場合はnull
     */
    public function findById(int $id): ?ArticleService
    {
        $model = ArticleServiceModel::find($id);

        return $model ? $this->toEntity($model) : null;
    }

    /**
     * 全ての ArticleService エンティティを取得して返却する。
     *
     * ArticleServiceModel の全レコードを取得し、各レコードを ArticleService エンティティに変換した上で配列として返します。
     *
     * @return ArticleService[] 変換済み ArticleService エンティティの一覧
     */
    public function findAll(): array
    {
        $models = ArticleServiceModel::all();
        $entities = [];
        foreach ($models as $model) {
            $entities[] = $this->toEntity($model);
        }

        return $entities;
    }

    /**
     * 渡された ArticleService エンティティを元に新しい記事サービスを作成し、そのエンティティを返します。
     *
     * 本メソッドはエンティティの名前を用いてデータベースにレコードを作成し、作成後、モデルをエンティティに変換して返却します。
     *
     * @param ArticleService $articleService 作成する記事サービスのエンティティ
     * @return ArticleService 作成された記事サービスのエンティティ
     */
    public function create(ArticleService $articleService): ArticleService
    {
        $model = ArticleServiceModel::create(['name' => $articleService->name()->value()]);

        return $this->toEntity($model);
    }

    /**
     * 指定した ArticleService エンティティの内容で記事サービスデータを更新し、更新後のエンティティを返します。
     *
     * 指定された ID の記事サービスが存在しない場合は DomainException をスローします。
     *
     * @param ArticleService $articleService 更新情報を含む記事サービスエンティティ
     * @return ArticleService 更新された記事サービスエンティティ
     * @throws DomainException 指定された記事サービスが見つからない場合にスローされます
     */
    public function update(ArticleService $articleService): ArticleService
    {
        $model = ArticleServiceModel::find($articleService->id()->value());

        if (! $model) {
            throw new \DomainException("ID: {$articleService->id()->value()} の記事サービスが見つかりません。");
        }

        $model->name = $articleService->name()->value();
        $model->save();

        return $this->toEntity($model);
    }

    /**
     * 指定された ArticleService エンティティに対応するレコードを削除する。
     *
     * 渡された ArticleService から ID を取得し、その ID に一致する ArticleServiceModel のレコードをデータベースから削除します。
     */
    public function delete(ArticleService $articleService): void
    {
        ArticleServiceModel::destroy($articleService->id()->value());
    }

    /**
     * 指定された ArticleService エンティティに対応する記事サービスを完全に削除する。
     *
     * このメソッドは、ソフトデリートされたレコードも含めてデータベースから記事サービスを検索し、
     * 存在しない場合は DomainException をスローします。見つかった場合は、永続的に削除します。
     *
     * @param ArticleService $articleService 削除対象の記事サービスエンティティ
     *
     * @throws \DomainException 指定された ID の記事サービスが見つからない場合
     */
    public function forceDelete(ArticleService $articleService): void
    {
        $model = ArticleServiceModel::withTrashed()->find($articleService->id()->value());

        if (! $model) {
            throw new \DomainException("ID: {$articleService->id()->value()} の記事サービスが見つかりません。");
        }
        $model->forceDelete();
    }

    /**
     * 指定された ArticleServiceModel から ArticleService エンティティを生成して返します。
     *
     * このメソッドは、ArticleServiceModel の ID と名称を元に、各々 ArticleServiceId および ArticleServiceName のインスタンスを生成し、
     * それらを用いて ArticleService エンティティを作成します。
     *
     * @param ArticleServiceModel $model 変換元の ArticleServiceModel オブジェクト
     * @return ArticleService 生成された ArticleService エンティティ
     */
    private function toEntity(ArticleServiceModel $model): ArticleService
    {
        return new ArticleService(
            new ArticleServiceId($model->id),
            new ArticleServiceName($model->name)
        );
    }
}
