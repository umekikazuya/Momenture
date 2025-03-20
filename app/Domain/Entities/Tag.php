<?php

namespace App\Domain\Entities;

class Tag
{
    private int $id;

    private string $name;

    /**
     * タグエンティティの新しいインスタンスを初期化します。
     *
     * このコンストラクタは、タグの識別子および名前を用いてエンティティのプロパティを設定します。
     *
     * @param int $id タグの識別子
     * @param string $name タグの名前
     */
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * タグの識別子を返します。
     *
     * このメソッドは、オブジェクトの内部で保持しているタグのIDを返します。
     *
     * @return int タグの識別子
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * タグの名称を返します。
     *
     * このメソッドは、タグクラスに保持される名称を取得するためのゲッターメソッドです。
     *
     * @return string タグの名称
     */
    public function name(): string
    {
        return $this->name;
    }
}
