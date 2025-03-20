<?php

declare(strict_types=1);

namespace App\Application\DTOs;

use App\Domain\Entities\ArticleService;
use App\Domain\Enums\ArticleStatus;
use App\Domain\ValueObjects\ArticleLink;
use App\Domain\ValueObjects\ArticleTitle;
use App\Http\Requests\Article\UpdateRequest;

class UpdateArticleInput
{
    /**
     * 指定された入力に基づいて UpdateArticleInput の新しいインスタンスを生成する。
     *
     * 各プロパティは記事更新に必要なデータを保持します。
     *
     * @param int $id 記事の一意な識別子。
     * @param ArticleTitle|null $title 記事タイトルをラップする値オブジェクト。未指定の場合は null。
     * @param ArticleLink|null $link 記事リンクをラップする値オブジェクト。未指定の場合は null。
     * @param ArticleStatus|null $status 記事の状態を示す列挙体。未指定の場合は null。
     * @param ArticleService|null $service 関連するサービス情報をラップする値オブジェクト。未指定の場合は null。
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
     * 指定されたIDとリクエストからUpdateArticleInputの新しいインスタンスを生成する。
     *
     * リクエストの各フィールドが設定されている場合、それぞれ対応する値オブジェクトまたはenumを生成する。
     * 具体的には、'title'、'link'、'status'、および'service_id'が存在する場合に、
     * ArticleTitle、ArticleLink、ArticleStatus、ArticleServiceが生成される（service_idの場合、第2引数は空文字）。
     *
     * @param int $id 更新するアーティクルの一意のID。
     * @param UpdateRequest $request アーティクル更新情報が含まれるリクエストオブジェクト。
     * @return self 指定されたリクエストに基づいて構築されたUpdateArticleInputのインスタンス。
     */
    public static function fromRequest(int $id, UpdateRequest $request): self
    {
        return new self(
            $id,
            $request->filled('title') ? new ArticleTitle($request->title) : null,
            $request->filled('link') ? new ArticleLink($request->link) : null,
            $request->filled('status') ? ArticleStatus::from($request->status) : null,
            $request->filled('service_id')
                ? new ArticleService($request->service_id, '')
                : null
        );
    }
}
