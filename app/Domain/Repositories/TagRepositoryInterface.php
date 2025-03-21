<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Tag;

interface TagRepositoryInterface
{
    /**
     * 指定されたIDに対応するタグエンティティを取得します。
     *
     * 与えられた一意のIDに基づいてタグを検索し、存在する場合は該当するタグオブジェクトを返します。
     * 見つからない場合はnullを返します。
     *
     * @param  int $id タグを識別する一意のID
     * @return Tag|null 該当するタグエンティティ、存在しない場合はnull
     */
    public function findById(int $id): ?Tag;

    /**
     * 指定されたタグ名と一致するTagオブジェクトを取得します。
     *
     * 与えられた名前で検索を行い、一致するTagが存在しない場合はnullを返します。
     *
     * @param  string $name 検索対象のタグ名
     * @return Tag|null 該当するTagオブジェクト、もしくは存在しない場合はnull
     */
    public function findByName(string $name): ?Tag;

    /**
     * 指定された Tag エンティティをデータストアに保存します。
     *
     * @param Tag $tag 保存対象の
     *                 Tag
     *                 エンティティ
     */
    public function save(Tag $tag): void;

    /**
     * 指定されたTagエンティティを削除します。
     *
     * このメソッドは、永続層から指定されたTagエンティティを削除する処理を実行します。
     *
     * @param Tag $tag 削除対象のTagエンティティ
     */
    public function delete(Tag $tag): void;
}
