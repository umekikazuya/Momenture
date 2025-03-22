<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Tag;

interface TagRepositoryInterface
{
    /**
     * 指定されたIDに対応するタグエンティティを取得。
     *
     * 与えられた一意のIDに基づいてタグを検索し、存在する場合は該当するタグオブジェクトを返す。
     *
     * @param  int $id タグを識別する一意のID
     * @return Tag 該当するタグエンティティ
     *
     * @throws \DomainException 指定されたIDに対応するタグが存在しない場合
     * @throws \RuntimeException データベースエラーなど、予期しない例外が発生した場合
     */
    public function findById(int $id): Tag;

    /**
     * 指定されたタグ名と一致するTagオブジェクトを取得。
     *
     * 与えられた名前で検索を行う。
     *
     * @param  string $name 検索対象のタグ名
     * @return Tag 該当するTagオブジェクト
     *
     * @throws \DomainException 指定された名前に対応するタグが存在しない場合
     * @throws \RuntimeException データベースエラーなど、予期しない例外が発生した場合
     */
    public function findByName(string $name): Tag;

    /**
     * 指定された Tag エンティティをデータストアに保存。
     *
     * @param Tag $tag 保存対象のTagエンティティ
     *
     * @throws \RuntimeException データベースエラーなど、予期しない例外が発生した場合
     */
    public function save(Tag $tag): void;

    /**
     * 指定されたTagエンティティを削除。
     *
     * このメソッドは、永続層から指定されたTagエンティティを削除する処理を実行。
     *
     * @param Tag $tag 削除対象のTagエンティティ
     *
     * @throws \RuntimeException データベースエラーなど、予期しない例外が発生した場合
     */
    public function delete(Tag $tag): void;
}
