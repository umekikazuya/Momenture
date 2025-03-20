<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Tag;

interface TagRepositoryInterface
{
    /**
 * 指定されたIDに対応するTagを取得します。
 *
 * 指定されたタグIDに一致するTagが存在する場合、そのTagオブジェクトを返し、存在しない場合はnullを返します。
 *
 * @param int $id 取得対象のタグID
 * @return Tag|null マッチするタグが存在すればTagオブジェクト、存在しなければnull
 */
public function findById(int $id): ?Tag;

    /**
 * 指定された名前に一致するタグを検索し、該当するタグがあれば返します。
 *
 * 与えられた名前を基にタグを検索し、見つかった場合は対応する Tag オブジェクトを、
 * 見つからなかった場合は null を返します。
 *
 * @param string $name 検索対象のタグ名
 * @return Tag|null 検索に一致するタグが存在する場合は Tag オブジェクト、存在しない場合は null
 */
public function findByName(string $name): ?Tag;

    /**
 * 指定されたTagエンティティを保存する。
 *
 * 渡されたTagオブジェクトをデータストアに永続化します。
 *
 * @param Tag $tag 保存対象のTagエンティティ
 */
public function save(Tag $tag): void;

    /**
 * 指定された Tag エンティティを削除します。
 *
 * 与えられた Tag オブジェクトを永続層から削除し、その存在を取り除きます。
 *
 * @param Tag $tag 削除対象の Tag エンティティ
 */
public function delete(Tag $tag): void;
}
