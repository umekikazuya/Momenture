<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Entities\FeaturedArticle;

interface FeaturedArticleRepositoryInterface
{
    /**
     * 指定されたIDに対応するFeaturedArticleエンティティを取得する。
     *
     * 入力されたIDに基づき、該当するFeaturedArticleエンティティが存在すればそれを返し、存在しない場合はnullを返します。
     *
     * @param  int  $id  検索対象のFeaturedArticleエンティティのID
     * @return FeaturedArticle|null 該当するエンティティ、存在しない場合はnull
     */
    public function findById(int $id): ?FeaturedArticle;

    /**
     * 有効なFeaturedArticleエンティティの配列を返します。
     *
     * リポジトリ内で現在有効とされる記事のみを取得します。
     *
     * @return array 有効なFeaturedArticleエンティティの配列
     */
    public function findActive(): array;

    /**
     * 指定されたFeaturedArticleエンティティをリポジトリに保存します。
     *
     * @param  FeaturedArticle  $featuredArticle  保存対象のFeaturedArticleオブジェクト
     */
    public function save(FeaturedArticle $featuredArticle): void;

    /**
     * 指定されたFeaturedArticleエンティティを削除します。
     *
     * 渡されたFeaturedArticleオブジェクトをリポジトリから削除する操作を定義します。
     *
     * @param  FeaturedArticle  $featuredArticle  削除対象のFeaturedArticleエンティティ
     */
    public function delete(FeaturedArticle $featuredArticle): void;
}
