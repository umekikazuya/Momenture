<?php

namespace App\Domain\Entities;

class ArticleService
{
    private int $id;

    private string $name;

    /**
     * ArticleServiceクラスの新しいインスタンスを初期化します。
     *
     * 指定されたIDと名称でArticleServiceのプロパティを初期化します。
     *
     * @param int $id サービスの一意な識別子
     * @param string $name サービスの名称
     */
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * 記事サービスの識別子を返します。
     *
     * このメソッドは記事サービスの一意なIDを取得するためのゲッターです。
     *
     * @return int 記事サービスの識別子
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * 記事サービスの名前を返します。
     *
     * このメソッドは記事サービスに紐付けられた名前を取得します。
     *
     * @return string 記事サービスの名前
     */
    public function name(): string
    {
        return $this->name;
    }
}
