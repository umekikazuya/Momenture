<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Entities\ArticleService;

interface ArticleServiceRepositoryInterface
{
    /**
     * すべてのArticleServiceエンティティを取得。
     *
     * @return array ArticleServiceエンティティの配列
     */
    public function findAll(): array;

    /**
     * 指定されたIDに対応するArticleServiceエンティティを取得。
     *
     * 指定されたIDに基づいてArticleServiceエンティティを検索し、該当するエンティティが存在すれば返す。
     *
     * @param  int $id 検索対象となるArticleServiceエンティティの一意な識別子。
     * @return ArticleService 対応するArticleServiceエンティティが存在する場合はそのオブジェクト。
     *
     * @throws \DomainException 指定されたIDに対応する記事サービスが存在しない場合
     * @throws \RuntimeException データベースエラーなど、予期しない例外が発生した場合
     */
    public function findById(int $id): ArticleService;

    /**
     * 与えられた ArticleService エンティティを元に新規レコードを作成し、作成後のエンティティを返却します。
     *
     * @param  ArticleService $entity 作成対象のArticleServiceインスタンス
     * @return ArticleService 作成された ArticleService エンティティ
     *
     * @throws \RuntimeException データベースエラーなど、予期しない例外が発生した場合
     */
    public function create(ArticleService $entity): ArticleService;

    /**
     * 指定された ArticleService エンティティの内容を更新し、更新後のエンティティを返します。
     *
     * 渡された ArticleService オブジェクトの情報に基づいて、データソース上の対応するレコードを更新します。
     *
     * @param  ArticleService $entity 更新対象のArticleServiceエンティティ。
     * @return ArticleService 更新後の ArticleService エンティティ。
     *
     * @throws \DomainException 指定された記事サービスが見つからない場合にスロー。
     */
    public function update(ArticleService $entity): ArticleService;

    /**
     * 指定された ArticleService エンティティを削除する。
     *
     * @param ArticleService $entity 削除対象のArticleServiceエンティティ
     *
     * @throws \RuntimeException データベースエラーなど、予期しない例外が発生した場合
     */
    public function delete(ArticleService $entity): void;

    /**
     * 指定された ArticleService エンティティを物理削除を実施。
     *
     * このメソッドは、ArticleService エンティティに対して論理削除ではなく、強制的な物理削除を実行。
     *
     * @param ArticleService $entity 削除対象のArticleServiceエンティティ
     *
     * @throws \RuntimeException データベースエラーなど、予期しない例外が発生した場合
     */
    public function forceDelete(ArticleService $entity): void;
}
