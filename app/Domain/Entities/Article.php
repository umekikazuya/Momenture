<?php

namespace App\Domain\Entities;

use App\Domain\Enums\ArticleStatus;
use App\Domain\ValueObjects\ArticleLink;
use App\Domain\ValueObjects\ArticleTitle;

class Article
{
    /**
     * Article エンティティの新しいインスタンスを初期化する。
     *
     * @param int $id 記事の一意な識別子
     * @param ArticleTitle $title 記事のタイトルを表現する値オブジェクト
     * @param ArticleStatus $status 記事の状態（例：公開、下書き）を表現する値オブジェクト
     * @param ArticleService $service 記事に関連するサービスのインスタンス
     * @param \DateTimeImmutable $createdAt 記事の作成日時
     * @param \DateTimeImmutable $updatedAt 記事の最終更新日時
     * @param ArticleLink|null $link 記事に関連するリンク（存在する場合）
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
        $this->id = $id;
        $this->title = $title;
        $this->status = $status;
        $this->service = $service;
        $this->link = $link;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * 記事の一意な識別子を返す。
     *
     * このメソッドは記事エンティティに割り当てられたIDを取得します。
     *
     * @return int 記事の一意な識別子
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * 記事のタイトルを返します。
     *
     * このメソッドは、記事に設定されている ArticleTitle インスタンスを取得します。
     *
     * @return ArticleTitle 記事のタイトル
     */
    public function title(): ArticleTitle
    {
        return $this->title;
    }

    /**
     * 記事に関連するサービスインスタンスを返します。
     *
     * @return ArticleService 記事に紐付くサービスインスタンス
     */
    public function service(): ArticleService
    {
        return $this->service;
    }

    /**
     * 記事の作成日時を返す。
     *
     * このメソッドは、記事が作成された日時を示す DateTimeImmutable オブジェクトを返します。
     *
     * @return \DateTimeImmutable 記事の作成日時
     */
    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * 記事の最終更新日時を取得する。
     *
     * このメソッドは、記事の更新日時を表す DateTimeImmutable インスタンスを返します。
     *
     * @return \DateTimeImmutable 最終更新日時
     */
    public function updatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * 記事のステータスを取得します。
     *
     * このメソッドは、記事の現在の状態（例：公開、下書きなど）を表す ArticleStatus オブジェクトを返します。
     *
     * @return ArticleStatus 現在のステータス
     */
    public function status(): ArticleStatus
    {
        return $this->status;
    }

    /**
     * 記事が公開状態であるか確認する。
     *
     * 現在のステータスが ArticleStatus::PUBLISHED である場合に true を返します。
     *
     * @return bool 公開済みの場合は true、それ以外の場合は false。
     */
    public function isPublished(): bool
    {
        return $this->status === ArticleStatus::PUBLISHED;
    }

    /**
     * 記事が下書き状態かどうかを判定する。
     *
     * 現在のステータスが ArticleStatus::DRAFT である場合に true を返します。
     *
     * @return bool 下書き状態の場合は true、それ以外の場合は false
     */
    public function isDraft(): bool
    {
        return $this->status === ArticleStatus::DRAFT;
    }

    /**
     * 記事にリンクが設定されているかどうかを判定します。
     *
     * リンクプロパティが null でなければ true を返します。
     *
     * @return bool リンクが設定されている場合は true、されていない場合は false
     */
    public function hasLink(): bool
    {
        return $this->link !== null;
    }

    /**
     * 記事に関連付けられたリンクを返します。
     *
     * 記事にリンクが設定されている場合は、そのArticleLinkオブジェクトを返し、設定されていない場合はnullを返します。
     *
     * @return ArticleLink|null 記事に関連付けられたリンク、存在しない場合はnull
     */
    public function link(): ?ArticleLink
    {
        return $this->link;
    }

    /**
     * 記事を公開状態に更新する。
     *
     * 現在の記事状態が公開可能でない場合、DomainException をスローする。
     * 公開に成功すると、記事の状態が公開に更新され、更新日時が現在の日時に変更される。
     *
     * @throws \DomainException 公開が許可されていない場合にスローされる
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
     * 指定された記事タイトルで記事のタイトルを更新し、更新日時を現在の日時にリフレッシュする。
     *
     * @param ArticleTitle $title 更新する記事のタイトル。
     */
    public function updateTitle(ArticleTitle $title): void
    {
        $this->title = $title;
        $this->updatedAt = new \DateTimeImmutable();
    }

    /**
     * 記事のリンクを更新し、最新の更新日時を設定する。
     *
     * 指定したリンクで記事に関連づけられたリンクを更新する。null を渡すとリンクが解除される。
     *
     * @param ArticleLink|null $link 記事に設定するリンク。null の場合、リンクを解除する。
     */
    public function updateLink(?ArticleLink $link): void
    {
        $this->link = $link;
        $this->updatedAt = new \DateTimeImmutable();
    }

    /**
     * 記事の関連サービスを更新し、更新日時を現在の時刻に更新する。
     *
     * 指定された ArticleService インスタンスを記事のサービスとして設定し、更新日時を最新の日時にリフレッシュします。
     *
     * @param ArticleService $service 更新対象のサービスインスタンス
     */
    public function updateArticleService(ArticleService $service): void
    {
        $this->service = $service;
        $this->updatedAt = new \DateTimeImmutable();
    }

    /**
     * 指定したステータスに更新し、記事の最終更新日時を現在の日時に更新する。
     *
     * @param ArticleStatus $status 新しい記事のステータス
     */
    public function updateStatus(ArticleStatus $status): void
    {
        $this->status = $status;
        $this->updatedAt = new \DateTimeImmutable();
    }
}
