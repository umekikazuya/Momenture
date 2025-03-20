<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $table = 'articles';

    protected $fillable = [
        'title',
        'status',
        'article_service_id',
        'link',
        'created_at',
        'updated_at',
    ];

    /**
     * このモデルが属する ArticleService との関連を定義します。
     *
     * Eloquent の belongsTo リレーションを利用して、この記事が所属する ArticleService を取得します。
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function articleService()
    {
        return $this->belongsTo(ArticleService::class);
    }

    /**
     * 記事とタグの多対多リレーションシップを定義します。
     *
     * このメソッドは、記事に関連付けられたタグを取得するためのEloquent
     * のbelongsToManyリレーションを返します。
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
