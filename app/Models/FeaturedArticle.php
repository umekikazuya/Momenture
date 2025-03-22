<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 注目記事モデル
 */
class FeaturedArticle extends Model
{
    protected $table = 'featured_articles';

    protected $fillable = [
        'article_id',
        'priority',
        'is_active',
    ];

    public $timestamps = true;

    /**
     * Article モデルとの belongsTo リレーションを返します。
     *
     * このメソッドは、現在の FeaturedArticle モデルが所属する Article モデルとの関係を定義します。
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
