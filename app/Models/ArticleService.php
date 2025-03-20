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
     * 記事モデルとの1対多リレーションを返します。
     *
     * このメソッドは、ArticleServiceに関連付けられた複数の記事（Articleモデル）を取得するためのリレーションを定義します。
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
