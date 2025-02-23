<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Profile extends Model
{
    protected $table = 'profiles';

    protected $fillable = [
        'address',
        'display_name',
        'display_short_name',
        'from',
        'github',
        'introduction',
        'job',
        'likes',
        'qiita',
        'skill',
        'summary_introduction',
        'zenn',
    ];

    // JSONBや配列型を配列に自動キャスト
    protected $casts = [
        'skill' => 'array',
        'likes' => 'array',
    ];
}
