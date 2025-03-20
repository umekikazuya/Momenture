<?php

namespace Database\Seeders;

use App\Models\ArticleService;
use Illuminate\Database\Seeder;

class ArticleServiceSeeder extends Seeder
{
    /**
     * ArticleServiceモデルに初期データを登録する。
     *
     * このメソッドはArticleServiceモデルのcreateメソッドを用いて、'Qiita'と'Zenn'のエントリをデータベースに作成します。
     */
    public function run()
    {
        ArticleService::create(['name' => 'Qiita']);
        ArticleService::create(['name' => 'Zenn']);
    }
}
