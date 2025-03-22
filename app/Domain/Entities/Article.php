<?php

namespace App\Domain\Entities;

use App\Domain\Enums\ArticleStatus;
use App\Domain\ValueObjects\ArticleLink;
use App\Domain\ValueObjects\ArticleTitle;

class Article
{
    /**
     * Articleエンティティを初期化。
     *
     * 記事の一意なID、タイトル、ステータス、サービス、作成日時、更新日時、およびオプションのリンクを設定。
     * 検証やエラー処理は実施しない。
     */
    public function __construct(
        private int $id,
        private ArticleTitle $title,
        private ArticleStatus $status,
        private ArticleService $service,
        private \DateTimeImmutable $createdAt,
        private \DateTimeImmutable $updatedAt,
        private ?ArticleLink $link = null
    ) {
    }

    /**
     * 記事の一意なIDを取得。
     *
     * このメソッドは、記事エンティティに設定された識別子を返す。
     *
     * @return int 記事のID
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * 記事のタイトルを返却。
     *
     * @return ArticleTitle 記事のタイトルを表すオブジェクト。
     */
    public function title(): ArticleTitle
    {
        return $this->title;
    }

    /**
     * 記事に関連するサービスを取得。
     *
     * @return ArticleService 記事に対応するサービスオブジェクト
     */
    public function service(): ArticleService
    {
        return $this->service;
    }

    /**
     * 記事の作成日時を取得する。
     *
     * このメソッドは記事が作成された日時を表す DateTimeImmutable オブジェクトを返す。
     *
     * @return \DateTimeImmutable 記事の作成日時
     */
    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * 記事の最新の更新日時を返す。
     *
     * @return \DateTimeImmutable 最新の更新日時
     */
    public function updatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * 記事の状態を取得する。
     *
     * 現在の記事の状態（例：公開、下書きなど）を返す。
     *
     * @return ArticleStatus 記事の状態
     */
    public function status(): ArticleStatus
    {
        return $this->status;
    }

    /**
     * 記事が公開済みかどうかを判定する。
     *
     * 現在のステータスが ArticleStatus::PUBLISHED と一致している場合に true を返す。
     *
     * @return bool 公開済みの場合は true、それ以外は false。
     */
    public function isPublished(): bool
    {
        return $this->status === ArticleStatus::PUBLISHED;
    }

    /**
     * 現在の記事が下書き状態かどうかを確認する。
     *
     * 現在のステータスが `ArticleStatus::DRAFT` と一致する場合に、記事が下書き状態であると判断します。
     *
     * @return bool 下書き状態の場合は true、それ以外の場合は false を返す。
     */
    public function isDraft(): bool
    {
        return $this->status === ArticleStatus::DRAFT;
    }

    /**
     * 記事にリンクが存在するかを判定する。
     *
     * リンクが設定されている場合は true、設定されていない場合は false を返す。
     *
     * @return bool リンクの有無を示す真偽値
     */
    public function hasLink(): bool
    {
        return $this->link !== null;
    }

    /**
     * 記事に関連付けられたリンクを取得する.
     *
     * リンクが設定されていない場合は null を返す.
     *
     * @return ArticleLink|null 記事のリンクまたは null
     */
    public function link(): ?ArticleLink
    {
        return $this->link;
    }

    /**
     * 記事を公開状態に更新。
     *
     * 現在の記事状態が公開可能な場合、記事の状態を「公開済み」に設定し、更新日時を現在の日時に更新。
     * 公開できない状態の場合は、DomainException をスローします。
     *
     * @throws \DomainException 記事が公開できない状態の場合にスローされます。
     */
    public function publish(): void
    {
        if (! $this->status->canBePublished()) {
            throw new \DomainException('記事を公開できません。');
        }
        $this->status = ArticleStatus::PUBLISHED;
        $this->updatedAt = new \DateTimeImmutable();
    }

    /**
     * 記事のタイトルを新しい値に更新し、更新日時を現在時刻に設定。
     *
     * @param ArticleTitle $title 変更後の記事タイトルオブジェクト
     */
    public function updateTitle(ArticleTitle $title): void
    {
        $this->title = $title;
        $this->updatedAt = new \DateTimeImmutable();
    }

    /**
     * 記事のリンクを更新し、更新日時を更新する。
     *
     * 指定されたリンクで記事のリンクプロパティを上書きします。リンクが null の場合は、リンクが削除されます。
     *
     * @param ArticleLink|null $link 更新する記事リンク（null の場合、リンクの削除を示す）
     */
    public function updateLink(?ArticleLink $link): void
    {
        $this->link = $link;
        $this->updatedAt = new \DateTimeImmutable();
    }

    /**
     * 記事に関連する ArticleService を更新し、更新日時を現在の日時に更新します。
     */
    public function updateArticleService(ArticleService $service): void
    {
        $this->service = $service;
        $this->updatedAt = new \DateTimeImmutable();
    }

    /**
     * 記事の状態を更新し、更新日時を現在の日時に更新します。
     *
     * @param ArticleStatus $status 記事に設定する新しい状態
     */
    public function updateStatus(ArticleStatus $status): void
    {
        $this->status = $status;
        $this->updatedAt = new \DateTimeImmutable();
    }
}
