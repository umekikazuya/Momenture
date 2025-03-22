<?php

declare(strict_types=1);

namespace App\Application\DTOs;

use App\Domain\Entities\ArticleService;
use App\Domain\Enums\ArticleStatus;
use App\Domain\ValueObjects\ArticleLink;
use App\Domain\ValueObjects\ArticleServiceId;
use App\Domain\ValueObjects\ArticleServiceName;
use App\Domain\ValueObjects\ArticleTitle;
use App\Http\Requests\Article\UpdateRequest;

class UpdateArticleInput
{
    /**
     * 記事更新用の入力データを初期化するコンストラクタ。
     *
     * このコンストラクタは、記事の一意な識別子と、任意の更新データ（タイトル、リンク、状態、サービス）を受け取り、
     * インスタンスを生成します。
     *
     * @param int                 $id      記事の一意な識別子。
     * @param ArticleTitle|null   $title   記事のタイトル（任意）。
     * @param ArticleLink|null    $link    記事のリンク（任意）。
     * @param ArticleStatus|null  $status  記事の状態（任意）。
     * @param ArticleService|null $service 記事に関連付けられたサービス（任意）。
     */
    public function __construct(
        public int $id,
        public ?ArticleTitle $title = null,
        public ?ArticleLink $link = null,
        public ?ArticleStatus $status = null,
        public ?ArticleService $service = null,
    ) {
    }

    /**
     * 指定された記事IDと更新リクエストから、UpdateArticleInput インスタンスを生成する。
     *
     * リクエスト内の"title"、"link"、"status"、および"service_id"フィールドが存在する場合、
     * それぞれ ArticleTitle、ArticleLink、ArticleStatus、ArticleService オブジェクトに変換し、
     * 該当フィールドが未設定の場合は null としてプロパティに割り当てます。
     *
     * @param  int           $id      更新対象の記事の一意識別子
     * @param  UpdateRequest $request 更新データを含むリクエスト
     * @return self 更新内容に基づき構築された UpdateArticleInput インスタンス
     */
    public static function fromRequest(int $id, UpdateRequest $request): self
    {
        return new self(
            $id,
            $request->filled('title') ? new ArticleTitle($request->title) : null,
            $request->filled('link') ? new ArticleLink($request->link) : null,
            $request->filled('status') ? ArticleStatus::from($request->status) : null,
            $request->filled('service_id')
                ? new ArticleService(
                    id: new ArticleServiceId($request->service_id),
                    name: new ArticleServiceName(''),
                )
                : null
        );
    }
}
