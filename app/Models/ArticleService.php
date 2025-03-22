<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleService extends Model
{
    use SoftDeletes;

    protected $table = 'article_services';

    protected $fillable = [
        'name',
    ];

    /**
     * 関連する記事との1対多リレーションシップを定義する。
     *
     * このメソッドは、ArticleServiceに紐づくArticleモデルのコレクションを取得するためのEloquentリレーションシップを返します。
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Articleモデルとのリレーションシップインスタンス
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
