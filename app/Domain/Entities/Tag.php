<?php

namespace App\Domain\Entities;

class Tag
{
    private int $id;

    private string $name;

    /**
     * Tagインスタンスを初期化するコンストラクタ。
     *
     * タグの識別子と名前を設定します。
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
     * このメソッドは、タグに設定された一意の識別子を取得するためのアクセサです。
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
     * @return string タグの名称
     */
    public function name(): string
    {
        return $this->name;
    }
}
