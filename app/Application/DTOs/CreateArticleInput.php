<?php

declare(strict_types=1);

namespace App\Application\DTOs;

use App\Domain\Entities\ArticleService;
use App\Domain\Enums\ArticleStatus;
use App\Domain\ValueObjects\ArticleLink;
use App\Domain\ValueObjects\ArticleServiceName;
use App\Domain\ValueObjects\ArticleTitle;
use App\Http\Requests\Article\StoreRequest;

final class CreateArticleInput
{
    /**
     * 記事作成用の入力データDTOの各プロパティを初期化します。
     *
     * このコンストラクタは、記事タイトル、記事リンク（任意）、記事の状態、および関連する記事サービスを受け取り、
     * 対応する値オブジェクトとしてDTOのプロパティに設定します。
     *
     * @param ArticleTitle     $title   記事タイトルを表す値オブジェクト
     * @param ArticleLink|null $link    記事リンクを表す値オブジェクト（未設定の場合はnull）
     * @param ArticleStatus    $status  記事の状態を示す値オブジェクト
     * @param ArticleService   $service 記事に関連するサービス情報を保持する値オブジェクト
     */
    public function __construct(
        public readonly ArticleTitle $title,
        public readonly ?ArticleLink $link,
        public readonly ArticleStatus $status,
        public readonly ArticleService $service
    ) {
    }

    /**
     * StoreRequest から新しい CreateArticleInput インスタンスを生成する。
     *
     * 入力リクエストから記事のタイトル、リンク、ステータス、およびサービス情報を抽出し、それぞれ
     * ArticleTitle、ArticleLink、ArticleStatus、ArticleService のインスタンスに変換して初期化する。
     * リクエストにリンク情報が存在しない場合は、リンクは null として扱われる。
     *
     * @param  StoreRequest $request 記事作成に必要なデータを含むリクエスト
     * @return self 初期化された CreateArticleInput インスタンス
     */
    public static function fromRequest(StoreRequest $request): self
    {
        return new self(
            new ArticleTitle($request->title),
            $request->link
                ? new ArticleLink($request->link)
                : null,
            ArticleStatus::from($request->status),
            new ArticleService($request->service, new ArticleServiceName(''))
        );
    }
}
