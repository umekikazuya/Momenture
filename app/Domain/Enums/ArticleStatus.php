<?php

namespace App\Domain\Enums;

enum ArticleStatus: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';

    /**
     * 現在の状態が下書きであるかどうか判定し、記事が公開可能かを示す。
     *
     * ArticleStatus が DRAFT の場合に true を返し、それ以外の場合は false を返す。
     *
     * @return bool 下書き状態 (DRAFT) の場合は true、それ以外の場合は false
     */
    public function canBePublished(): bool
    {
        return $this === self::DRAFT;
    }
}
