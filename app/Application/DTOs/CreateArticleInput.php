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
     * 新しい CreateArticleInput インスタンスを生成する。
     *
     * このコンストラクタは、記事作成に必要な情報（タイトル、リンク、状態、サービス）を受け取り、
     * DTO の各プロパティを初期化します。
     *
     * @param ArticleTitle $title 記事のタイトルを表す値オブジェクト。
     * @param ArticleLink|null $link 記事に関連するリンクを表す値オブジェクト。リンクが存在しない場合は null。
     * @param ArticleStatus $status 記事の状態を表す値オブジェクト。
     * @param ArticleService $service 記事に関連するサービス情報を表す値オブジェクト。
     */
    public function __construct(
        public readonly ArticleTitle $title,
        public readonly ?ArticleLink $link,
        public readonly ArticleStatus $status,
        public readonly ArticleService $service
    ) {
    }

    /**
     * StoreRequestからCreateArticleInputのインスタンスを生成する。
     *
     * 指定されたリクエストから記事のタイトル、リンク、ステータス、およびサービスに関するデータを抽出し、
     * それらを元に新たなCreateArticleInputオブジェクトを初期化します。リンク情報が存在しない場合はnullとなります。
     *
     * @param StoreRequest $request 記事作成に必要なデータを含むリクエストオブジェクト
     * @return self 初期化済みのCreateArticleInputオブジェクト
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
