<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Entities\FeaturedArticle;

interface FeaturedArticleRepositoryInterface
{
    /**
 * 指定されたIDに対応するFeaturedArticleを取得する。
 *
 * 指定された整数IDに基づいてFeaturedArticleを検索し、該当する記事が存在する場合はそのオブジェクトを返します。
 * 該当する記事が見つからない場合はnullを返します。
 *
 * @param int $id 一意の識別子
 * @return FeaturedArticle|null 検索に一致するFeaturedArticleオブジェクト、または存在しない場合はnull
 */
public function findById(int $id): ?FeaturedArticle;

    /**
 * アクティブなFeaturedArticleエンティティの一覧を取得する。
 *
 * 現在アクティブとされているFeaturedArticleエンティティを配列として返します。
 *
 * @return array アクティブなFeaturedArticleエンティティの配列
 */
public function findActive(): array;

    /**
 * 指定されたFeaturedArticleエンティティを保存します。
 *
 * このメソッドは、渡されたFeaturedArticleオブジェクトをリポジトリに保存するための操作を実行します。
 *
 * @param FeaturedArticle $featuredArticle 保存対象のFeaturedArticleエンティティ。
 */
public function save(FeaturedArticle $featuredArticle): void;

    /**
 * 指定された FeaturedArticle オブジェクトをリポジトリから削除する。
 *
 * 指定された記事がリポジトリに存在する場合、その記事を削除してデータストア上の状態を更新します。
 *
 * @param FeaturedArticle $featuredArticle 削除対象の FeaturedArticle オブジェクト
 */
public function delete(FeaturedArticle $featuredArticle): void;
}
