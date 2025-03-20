<?php

namespace App\Domain\Entities;

class FeaturedArticle
{
    /**
     * FeaturedArticle の新しいインスタンスを初期化する。
     *
     * 指定された ID、記事、開始日時、および（オプションの）終了日時を用いて、インスタンスの各プロパティを設定します。
     *
     * @param int $id 記事の識別子。
     * @param Article $article 関連する記事オブジェクト。
     * @param \DateTimeImmutable $startDate インスタンスが有効となる開始日時。
     * @param \DateTimeImmutable|null $endDate （任意）インスタンスの有効期限。指定されない場合は null となります。
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
     * 現在の日時を基に、フィーチャー記事が有効かどうかを判定します。
     *
     * endDateが未設定の場合、またはendDateが現在日時より未来である場合、記事は有効とみなされます。
     *
     * @return bool 有効な場合はtrue、無効な場合はfalseを返します。
     */
    public function isActive(): bool
    {
        return $this->endDate === null || $this->endDate > new \DateTimeImmutable();
    }

    /**
     * 記事の識別子を返します。
     *
     * FeaturedArticle インスタンスに紐づく一意の識別子を返すためのメソッドです。
     *
     * @return int 記事の識別子
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * 関連する記事オブジェクトを返します。
     *
     * @return Article 関連付けられた記事を表す Article オブジェクト
     */
    public function article(): Article
    {
        return $this->article;
    }

    /**
     * 記事の開始日時を返します。
     *
     * このメソッドはフィーチャード記事の開始日時を保持する DateTimeImmutable オブジェクトを取得します。
     *
     * @return \DateTimeImmutable 開始日時
     */
    public function startDate(): \DateTimeImmutable
    {
        return $this->startDate;
    }

    /**
     * フィーチャー記事の終了日時を取得します。
     *
     * 終了日時が設定されていない場合は null を返します。
     *
     * @return \DateTimeImmutable|null フィーチャー記事の終了日時または null
     */
    public function endDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }
}
