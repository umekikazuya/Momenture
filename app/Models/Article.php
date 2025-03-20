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

    public function articleService()
    {
        return $this->belongsTo(ArticleService::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
