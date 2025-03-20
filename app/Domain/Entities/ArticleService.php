<?php

namespace App\Domain\Entities;

class ArticleService
{
    private int $id;

    private string $name;

    /**
     * 指定されたIDと名前を用いて記事サービスのプロパティを初期化するコンストラクタ。
     *
     * @param int $id 記事サービスの識別子
     * @param string $name 記事サービスの名前
     */
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * 記事サービスの識別子を返します。
     *
     * @return int 記事サービスの識別子
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * 記事サービスの名前を取得する。
     *
     * プロパティに格納された記事サービス名を文字列として返します。
     *
     * @return string 記事サービスの名前
     */
    public function name(): string
    {
        return $this->name;
    }
}
