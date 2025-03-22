<?php

namespace App\Domain\Enums;

enum ArticleStatus: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';

    /**
     * 記事が下書き状態であるかを確認し、出版可能かどうかを判断する。
     *
     * 現在の状態が下書き (DRAFT) の場合に true を返し、そうでなければ false を返します。
     *
     * @return bool 下書き状態なら true、それ以外は false。
     */
    public function canBePublished(): bool
    {
        return $this === self::DRAFT;
    }
}
