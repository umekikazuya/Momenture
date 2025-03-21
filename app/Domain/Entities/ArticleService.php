<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\ArticleServiceId;
use App\Domain\ValueObjects\ArticleServiceName;

class ArticleService
{
    /**
     * ArticleService のインスタンスを初期化する。
     *
     * コンストラクタは、記事サービスの識別子と名称を受け取り、オブジェクトの内部状態を設定します。
     *
     * @param ArticleServiceId $id 記事サービスの識別子を表す値オブジェクト
     * @param ArticleServiceName $name 記事サービスの名称を表す値オブジェクト
     */
    public function __construct(
        protected ArticleServiceId $id,
        protected ArticleServiceName $name,
    ) {
    }

    /**
     * 記事サービスの識別子を返します。
     *
     * @return ArticleServiceId 記事サービスのIDを表すオブジェクト。
     */
    public function id(): ArticleServiceId
    {
        return $this->id;
    }

    /**
     * 記事サービスの名前を取得します。
     *
     * @return ArticleServiceName 記事サービスの名前を表す値オブジェクト
     */
    public function name(): ArticleServiceName
    {
        return $this->name;
    }

    /**
     * アーティクルサービスの名前を新しい ArticleServiceName で更新します。
     *
     * 渡された値オブジェクトを使用して、サービス名プロパティを上書き更新します。
     *
     * @param ArticleServiceName $name 新しいサービス名を表す値オブジェクト
     */
    public function updateName(ArticleServiceName $name): void
    {
        $this->name = $name;
    }
}
