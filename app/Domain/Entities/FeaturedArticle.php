<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\FeaturedArticleId;
use App\Domain\ValueObjects\FeaturedPriority;

class FeaturedArticle
{
    /**
     * FeaturedArticleクラスのインスタンスを初期化するコンストラクタ。
     *
     * 指定された一意の識別子、記事ID、優先度、有効状態、および作成日時を用いて、FeaturedArticleオブジェクトのプロパティを初期化します。
     *
     * @param FeaturedArticleId $id        FeaturedArticleの識別子
     * @param int               $articleId 記事の識別ID
     * @param FeaturedPriority  $priority  記事の優先度
     * @param bool              $isActive  記事が有効かどうかのフラグ
     * @param \DateTimeImmutable $createdAt 作成日時
     */
    public function __construct(
        private FeaturedArticleId $id,
        private Article $article,
        private FeaturedPriority $priority,
        private bool $isActive,
        private \DateTimeImmutable $createdAt
    ) {
    }

    /**
     * FeaturedArticleの識別子を取得します。
     *
     * @return FeaturedArticleId FeaturedArticleの識別子
     */
    public function id(): FeaturedArticleId
    {
        return $this->id;
    }

    /**
     * FeaturedArticleに紐づくArticleオブジェクトを取得します。
     *
     * @return Article 関連する記事の詳細情報を保持するArticleオブジェクト
     */
    public function article(): Article
    {
        return $this->article;
    }

    /**
     * 記事の優先度を返します。
     *
     * このメソッドは、記事に設定された優先度を示す FeaturedPriority オブジェクトを取得します。
     *
     * @return FeaturedPriority 記事の優先度
     */
    public function priority(): FeaturedPriority
    {
        return $this->priority;
    }

    /**
     * フィーチャード記事がアクティブな状態かどうかを返します。
     *
     * このメソッドは、記事が現在有効（アクティブ）であるかを示すブール値を返します。
     *
     * @return bool 有効な場合は true、そうでない場合は false を返します。
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }
}
