<?php

namespace Database\Seeders;

use App\Models\ArticleService;
use Illuminate\Database\Seeder;

class ArticleServiceSeeder extends Seeder
{
    public function run()
    {
        ArticleService::create(['name' => 'Qiita']);
        ArticleService::create(['name' => 'Zenn']);
    }
}
