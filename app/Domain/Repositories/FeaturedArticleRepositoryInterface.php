<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Entities\FeaturedArticle;

interface FeaturedArticleRepositoryInterface
{
    /**
 * 指定されたIDに基づいてFeaturedArticleエンティティを取得する。
 *
 * 与えられた整数IDに一致するFeaturedArticleエンティティを検索し、エンティティが存在すればそれを返します。
 * 存在しない場合はnullを返します。
 *
 * @param int $id 検索対象のFeaturedArticleのID
 * @return FeaturedArticle|null 対応するFeaturedArticleエンティティ、または存在しない場合はnull
 */
public function findById(int $id): ?FeaturedArticle;

    /**
 * アクティブな FeaturedArticle エンティティの一覧を取得します。
 *
 * 現在アクティブな記事に対応する FeaturedArticle エンティティの配列を返します。
 *
 * @return FeaturedArticle[] アクティブな FeaturedArticle エンティティの配列
 */
public function findActive(): array;

    /**
 * 指定された FeaturedArticle エンティティを保存します。
 *
 * このメソッドは、与えられた FeaturedArticle エンティティをデータストアに保持するための操作を定義しています。
 *
 * @param FeaturedArticle $featuredArticle 保存対象の FeaturedArticle エンティティ
 */
public function save(FeaturedArticle $featuredArticle): void;

    /**
 * 指定されたFeaturedArticleエンティティをリポジトリから削除します。
 *
 * @param FeaturedArticle $featuredArticle 削除するFeaturedArticleエンティティ
 */
public function delete(FeaturedArticle $featuredArticle): void;
}
