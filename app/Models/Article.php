<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory;
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
     * ArticleService モデルとの belongsTo リレーションを返します。
     *
     * このメソッドは、現在の Article モデルが所属する ArticleService モデルとの関係を定義します。
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function articleService()
    {
        return $this->belongsTo(ArticleService::class);
    }

    /**
     * 記事に関連付けられたタグのリレーションシップを取得する。
     *
     * このメソッドは、Eloquent の belongsToMany リレーションシップを利用して、
     * 記事に紐づく複数のタグとの関連付けを返します。
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
