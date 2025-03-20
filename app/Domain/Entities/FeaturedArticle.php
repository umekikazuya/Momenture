<?php

namespace App\Domain\Entities;

class FeaturedArticle
{
    /**
     * FeaturedArticle オブジェクトの初期化を行う。
     *
     * 識別子、関連する記事、開始日時、および（任意の）終了日時を設定します。
     * 終了日時が指定されない場合は null として初期化されます。
     *
     * @param int $id 記事の識別子
     * @param Article $article 関連する記事を表すオブジェクト
     * @param \DateTimeImmutable $startDate 記事の開始日時
     * @param \DateTimeImmutable|null $endDate 記事の終了日時。終了日時が未設定の場合は null
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
     * 現在、フィーチャー記事がアクティブかどうかを判定する。
     *
     * 終了日が未設定、または終了日が現在の日時より未来の場合にtrueを返します。
     *
     * @return bool フィーチャー記事がアクティブであればtrue、そうでなければfalse。
     */
    public function isActive(): bool
    {
        return $this->endDate === null || $this->endDate > new \DateTimeImmutable();
    }

    /**
     * 特集記事の識別子を取得します。
     *
     * このメソッドは、FeaturedArticleオブジェクトの一意なIDを返します。
     *
     * @return int 特集記事の識別子
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * 関連付けられた Article オブジェクトを返します。
     *
     * FeaturedArticle に紐付く記事の Article オブジェクトを取得します。
     *
     * @return Article 関連する記事の Article オブジェクト
     */
    public function article(): Article
    {
        return $this->article;
    }

    /**
     * 開始日時を返します。
     *
     * @return \DateTimeImmutable 記事の開始日時を表すオブジェクト
     */
    public function startDate(): \DateTimeImmutable
    {
        return $this->startDate;
    }

    /**
     * 終了日時を取得する。
     *
     * 終了日時が設定されていれば、その日時を示す DateTimeImmutable オブジェクトを返し、
     * 設定されていなければ null を返します。
     *
     * @return \DateTimeImmutable|null 終了日時、未設定の場合は null
     */
    public function endDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }
}
