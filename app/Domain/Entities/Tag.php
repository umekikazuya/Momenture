<?php

namespace App\Domain\Entities;

class Tag
{
    private int $id;

    private string $name;

    /**
     * タグエンティティのインスタンスを初期化する。
     *
     * このコンストラクタは、タグの固有識別子と名前を設定します。
     *
     * @param int $id タグの固有ID
     * @param string $name タグの名前
     */
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * タグの一意識別子を取得する。
     *
     * このメソッドは、内部プロパティに保持されているタグのIDを返します。
     *
     * @return int タグの一意識別子
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * タグの名前を返します。
     *
     * このメソッドは、タグの名前プロパティの値を取得します。
     *
     * @return string タグの名前
     */
    public function name(): string
    {
        return $this->name;
    }
}
