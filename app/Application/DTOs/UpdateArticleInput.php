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
     * UpdateArticleInput クラスのコンストラクタ
     *
     * 記事更新に必要な入力データを初期化します。記事の一意な識別子と、任意のタイトル、リンク、状態、および関連サービス情報を設定します。
     *
     * @param int $id 記事の一意な識別子
     * @param ArticleTitle|null $title （オプション）記事のタイトル情報を格納するオブジェクト
     * @param ArticleLink|null $link （オプション）記事のリンク情報を格納するオブジェクト
     * @param ArticleStatus|null $status （オプション）記事の状態を表す列挙型
     * @param ArticleService|null $service （オプション）記事に関連するサービス情報を格納するオブジェクト
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
     * UpdateRequestからUpdateArticleInputインスタンスを生成する。
     *
     * 指定された記事IDとリクエスト内のデータに基づき、記事更新に必要な属性（タイトル、リンク、ステータス、サービス）が入力されている場合に対応する値オブジェクトまたは列挙型に変換してセットアップする。
     *
     * @param int $id 記事の一意識別子。
     * @param UpdateRequest $request 記事更新のためのリクエストデータ。
     * @return self 初期化されたUpdateArticleInputインスタンス。
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
