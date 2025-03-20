<?php

namespace App\Models;

use App\Domain\Entities\ArticleService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'status',
        'service_id',
        'link',
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
