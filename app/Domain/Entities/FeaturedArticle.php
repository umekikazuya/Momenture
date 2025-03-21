<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\FeaturedArticleId;
use App\Domain\ValueObjects\FeaturedPriority;

class FeaturedArticle
{
    /**
     * FeaturedArticleクラスのインスタンスを初期化するコンストラクタ。
     *
     * 指定された一意のID、記事、開始日時、および（任意で）終了日時を用いて、FeaturedArticleオブジェクトのプロパティを初期化します。
     *
     * @param  FeaturedArticleId  $id  FeaturedArticleの識別子
     * @param  int  $articleId  記事ID
     * @param  FeaturedPriority  $priority  優先度
     * @param  bool  $isActive  有効かどうか
     * @param  \DateTimeImmutable  $createdAt  作成日時
     */
    public function __construct(
        private FeaturedArticleId $id,
        private int $articleId,
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
     * 優先度を取得します。
     */
    public function priority(): FeaturedPriority
    {
        return $this->priority;
    }

    /**
     * 有効かどうかを取得します。
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }
}
