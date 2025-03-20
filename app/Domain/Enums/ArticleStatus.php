<?php

namespace App\Domain\Enums;

enum ArticleStatus: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';

    /**
     * 現在のステータスが下書き (DRAFT) であるかを判定し、記事が公開可能かどうかを返す。
     *
     * ステータスが下書きの場合は true を返し、それ以外の場合は false を返す。
     *
     * @return bool 公開可能であれば true、それ以外は false。
     */
    public function canBePublished(): bool
    {
        return $this === self::DRAFT;
    }
}
