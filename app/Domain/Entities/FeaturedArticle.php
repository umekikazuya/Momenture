<?php

namespace App\Domain\Entities;

class FeaturedArticle
{
    /**
     * FeaturedArticleクラスのインスタンスを初期化するコンストラクタ。
     *
     * 指定された一意のID、記事、開始日時、および（任意で）終了日時を用いて、FeaturedArticleオブジェクトのプロパティを初期化します。
     *
     * @param int $id 記事の一意の識別子
     * @param Article $article 関連付けられた記事オブジェクト
     * @param \DateTimeImmutable $startDate 記事の開始日時
     * @param \DateTimeImmutable|null $endDate 記事の終了日時。終了日時が設定されていない場合はnull
     */
    public function __construct(
        private int $id,
        private Article $article,
        private \DateTimeImmutable $startDate,
        private ?\DateTimeImmutable $endDate = null
    ) {
        $this->id = $id;
        $this->article = $article;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * フィーチャード記事が現在有効かどうかを判定する
     *
     * 終了日時が未設定か、現在日時より未来の場合に、記事が有効であると判断する。
     *
     * @return bool 有効な場合はtrue、無効な場合はfalse
     */
    public function isActive(): bool
    {
        return $this->endDate === null || $this->endDate > new \DateTimeImmutable();
    }

    /**
     * フィーチャード記事の識別子を取得します。
     *
     * @return int フィーチャード記事の識別子
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * 関連付けられた記事オブジェクトを返します。
     *
     * このメソッドは、FeaturedArticleインスタンスに保持されているArticleオブジェクトを取得します。
     *
     * @return Article 関連付けられた記事オブジェクト
     */
    public function article(): Article
    {
        return $this->article;
    }

    /**
     * フィーチャー記事の開始日時を取得する。
     *
     * このメソッドは、フィーチャー記事として設定された開始日時を DateTimeImmutable オブジェクトで返します。
     *
     * @return \DateTimeImmutable フィーチャー記事の開始日時
     */
    public function startDate(): \DateTimeImmutable
    {
        return $this->startDate;
    }

    /**
     * 記事の終了日を取得します。
     *
     * 終了日が設定されている場合、その日時を返し、未設定の場合は null を返します。
     *
     * @return \DateTimeImmutable|null 終了日または null
     */
    public function endDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }
}
