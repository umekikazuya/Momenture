<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Tag;

interface TagRepositoryInterface
{
    /**
 * 指定されたIDに対応するTagエンティティを返す。
 *
 * 指定されたIDと一致するTagが存在する場合はそのエンティティを、存在しない場合はnullを返します。
 *
 * @param int $id タグの一意な識別子
 * @return Tag|null 一致するTagエンティティ、または存在しない場合はnull
 */
public function findById(int $id): ?Tag;

    /**
 * 指定された名前に一致する Tag エンティティを取得します。
 *
 * 指定した名前と一致する Tag が存在する場合、その Tag エンティティを返し、見つからない場合は null を返します。
 *
 * @param string $name 検索対象の Tag 名
 * @return Tag|null 該当する Tag エンティティ、または存在しない場合は null
 */
public function findByName(string $name): ?Tag;

    /**
 * 指定された Tag エンティティを保存します。
 *
 * 渡された Tag オブジェクトを永続化システムに保存するためのメソッドです。
 *
 * @param Tag $tag 保存対象のタグエンティティ
 */
public function save(Tag $tag): void;

    /**
 * 指定されたタグエンティティを削除します。
 *
 * @param Tag $tag 削除対象のタグエンティティ
 */
public function delete(Tag $tag): void;
}
