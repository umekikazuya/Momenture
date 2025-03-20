<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleService extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function articles()
    {
        return $this->belongsTo(Article::class);
    }
}
