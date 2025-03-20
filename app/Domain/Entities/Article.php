<?php

namespace App\Domain\Entities;

use App\Domain\Enums\ArticleStatus;
use App\Domain\ValueObjects\ArticleLink;
use App\Domain\ValueObjects\ArticleTitle;

class Article
{
    /**
     * Articleエンティティの新しいインスタンスを生成し、各プロパティを初期化する。
     *
     * 指定されたID、タイトル、状態、関連サービス、作成日時、更新日時、および（任意の）リンクに基づいて、Articleオブジェクトの各プロパティを設定します。
     *
     * @param int $id 記事の一意な識別子
     * @param ArticleTitle $title 記事のタイトル
     * @param ArticleStatus $status 記事の状態（例: 公開済み、下書きなど）
     * @param ArticleService $service 記事に関連するサービス
     * @param \DateTimeImmutable $createdAt 記事の作成日時
     * @param \DateTimeImmutable $updatedAt 記事の最終更新日時
     * @param ArticleLink|null $link （任意）記事に関連するリンク
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
     * 記事の一意な識別子を取得する。
     *
     * このメソッドは、記事に割り当てられた固有の整数IDを返します。
     *
     * @return int 記事のID
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * 記事のタイトルを返します。
     *
     * @return ArticleTitle 記事のタイトルを表すインスタンス
     */
    public function title(): ArticleTitle
    {
        return $this->title;
    }

    /**
     * 記事に関連するサービスを取得します。
     *
     * このメソッドは、記事に紐づいたサービスのインスタンスを返します。
     *
     * @return ArticleService 記事に関連するサービスのインスタンス
     */
    public function service(): ArticleService
    {
        return $this->service;
    }

    /**
     * 記事の作成日時を取得します。
     *
     * 記事が生成された際のタイムスタンプを示すDateTimeImmutableオブジェクトを返します。
     *
     * @return \DateTimeImmutable 作成日時オブジェクト
     */
    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * 記事の最終更新日時を取得する。
     *
     * 内部の updatedAt プロパティを DateTimeImmutable 型で返します。
     *
     * @return \DateTimeImmutable 記事が最後に更新された日時
     */
    public function updatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * 記事の現在の状態を取得します。
     *
     * 現在の ArticleStatus インスタンスを返却し、記事の状態（例: 公開済み、下書きなど）を示します。
     *
     * @return ArticleStatus 記事の状態
     */
    public function status(): ArticleStatus
    {
        return $this->status;
    }

    /**
     * 記事が公開状態であるかを判定する。
     *
     * 現在のステータスが ArticleStatus::PUBLISHED と一致する場合に true を返します。
     *
     * @return bool 公開されている場合は true、それ以外は false を返す
     */
    public function isPublished(): bool
    {
        return $this->status === ArticleStatus::PUBLISHED;
    }

    /**
     * 記事が下書き状態かを判定する。
     *
     * 現在のステータスが下書きに設定されている場合に true を返します。
     *
     * @return bool 下書き状態の場合に true、それ以外の場合に false を返します。
     */
    public function isDraft(): bool
    {
        return $this->status === ArticleStatus::DRAFT;
    }

    /**
     * 記事にリンクが設定されているかどうかを返します。
     *
     * リンクが設定されている場合は true を、設定されていない場合は false を返します。
     *
     * @return bool リンクの有無を示す真偽値
     */
    public function hasLink(): bool
    {
        return $this->link !== null;
    }

    /**
     * 記事に関連付けられたリンクを取得する。
     *
     * リンクが存在しない場合は null を返します。
     *
     * @return ?ArticleLink 記事のリンク
     */
    public function link(): ?ArticleLink
    {
        return $this->link;
    }

    /**
     * 記事を公開状態に更新します。
     *
     * 現在のステータスが公開可能な場合、記事のステータスを公開に変更し、更新日時を現在の日時に更新します。
     * 公開できない状態の場合は、DomainException をスローします。
     *
     * @throws \DomainException 記事が公開可能な状態でない場合にスローされます。
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
     * 記事のタイトルを更新し、更新日時を現在の時刻に設定します。
     *
     * @param ArticleTitle $title 新しい記事タイトル
     */
    public function updateTitle(ArticleTitle $title): void
    {
        $this->title = $title;
        $this->updatedAt = new \DateTimeImmutable();
    }

    /**
     * 記事のリンクを更新します。
     *
     * 渡されたリンクで記事のリンク情報を更新し、更新日時を現在の日時にリセットします。
     * 引数に null を渡すと、リンク情報が削除されます。
     *
     * @param ArticleLink|null $link 更新する記事のリンク。null の場合はリンクを解除します。
     */
    public function updateLink(?ArticleLink $link): void
    {
        $this->link = $link;
        $this->updatedAt = new \DateTimeImmutable();
    }

    /**
     * 記事の関連サービスを更新し、更新日時を現在の日時に設定する。
     *
     * @param ArticleService $service 新しい記事サービス
     */
    public function updateArticleService(ArticleService $service): void
    {
        $this->service = $service;
        $this->updatedAt = new \DateTimeImmutable();
    }

    /**
     * 記事の状態を更新し、更新日時を現在の日時にリセットする。
     *
     * 記事の状態を指定された新しいステータスに更新し、更新日時を現在日時に更新します。
     *
     * @param ArticleStatus $status 更新する記事の状態
     */
    public function updateStatus(ArticleStatus $status): void
    {
        $this->status = $status;
        $this->updatedAt = new \DateTimeImmutable();
    }
}
