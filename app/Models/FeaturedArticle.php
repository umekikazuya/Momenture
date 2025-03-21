<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeaturedArticle extends Model
{
    protected $table = 'featured_articles';

    protected $fillable = [
        'article_id',
        'priority',
        'is_active',
    ];

    /**
     * Article モデルとの belongsTo リレーションを返します。
     *
     * このメソッドは、現在の FeaturedArticle モデルが所属する Article モデルとの関係を定義します。
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
