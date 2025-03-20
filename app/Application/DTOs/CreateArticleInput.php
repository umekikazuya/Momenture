<?php

declare(strict_types=1);

namespace App\Application\DTOs;

use App\Domain\Entities\ArticleService;
use App\Domain\Enums\ArticleStatus;
use App\Domain\ValueObjects\ArticleLink;
use App\Domain\ValueObjects\ArticleTitle;
use App\Http\Requests\Article\StoreRequest;

final class CreateArticleInput
{
    /**
     * CreateArticleInput DTOのインスタンスを初期化するコンストラクタ。
     *
     * 記事作成用に必要なタイトル、オプションのリンク、ステータス、およびサービスの各値オブジェクトでプロパティを設定します。
     *
     * @param ArticleTitle $title 記事のタイトルを示す値オブジェクト
     * @param ArticleLink|null $link 記事のリンクを示す値オブジェクト。リンクが存在しない場合はnull
     * @param ArticleStatus $status 記事の状態を示す値オブジェクト
     * @param ArticleService $service 記事に関連するサービスを示す値オブジェクト
     */
    public function __construct(
        public readonly ArticleTitle $title,
        public readonly ?ArticleLink $link,
        public readonly ArticleStatus $status,
        public readonly ArticleService $service
    ) {
    }

    /**
     * StoreRequest から CreateArticleInput インスタンスを生成する.
     *
     * リクエストから記事のタイトル、リンク（オプション）、ステータス、及びサービス情報を抽出し、
     * 対応するバリューオブジェクトに変換して新しい CreateArticleInput インスタンスを返す。
     *
     * @param StoreRequest $request 記事作成に必要な情報を含むリクエストオブジェクト
     *
     * @return self 初期化済みの CreateArticleInput インスタンス
     */
    public static function fromRequest(StoreRequest $request): self
    {
        return new self(
            new ArticleTitle($request->title),
            new ArticleLink($request->link) ?? null,
            ArticleStatus::from($request->status),
            new ArticleService($request->service, '')
        );
    }
}
