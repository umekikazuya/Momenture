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
     * 記事に関連付けられているArticleServiceモデルを取得します。
     *
     * このメソッドは、記事が単一のArticleServiceに所属していることを示すbelongsToリレーションシップを定義します。
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function articleService()
    {
        return $this->belongsTo(ArticleService::class);
    }

    /**
     * 記事とタグ間の多対多リレーションを定義します。
     *
     * このメソッドは、記事に関連付けられたタグのコレクションを取得するためのリレーションを返します。
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
