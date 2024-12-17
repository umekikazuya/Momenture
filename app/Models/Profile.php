<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profiles';

    protected $fillable = [
        'github',
        'qiita',
        'address',
        'zenn',
        'skill',
        'display_name',
        'display_short_name',
        'from',
        'likes',
        'summary_introduction',
        'introduction',
        'job',
    ];
}
