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
     * Articleモデルとの一対多リレーションを定義します。
     *
     * ArticleServiceに関連する複数のArticleレコードを取得するためのリレーションを返します。
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
