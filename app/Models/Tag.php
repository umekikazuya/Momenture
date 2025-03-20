<?php

namespace App\Models;

use App\Domain\Entities\ArticleService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function service()
    {
        return $this->belongsTo(ArticleService::class);
    }
}
