<?php

namespace App\Domain\Entities;

class ArticleService
{
    private int $id;

    private string $name;

    /**
     * ArticleService クラスの新しいインスタンスを生成します。
     *
     * 記事サービスの識別子と名称を初期化します。
     *
     * @param int $id 記事サービスの識別子
     * @param string $name 記事サービスの名称
     */
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * 記事サービスのIDを返します。
     *
     * @return int 記事サービスのID
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * ArticleServiceの名前プロパティを返す。
     *
     * このメソッドは、ArticleServiceインスタンスに設定された名前の値を取得します。
     *
     * @return string 名前プロパティの値
     */
    public function name(): string
    {
        return $this->name;
    }
}
