<?php

namespace Database\Seeders;

use App\Models\ArticleService;
use Illuminate\Database\Seeder;

class ArticleServiceSeeder extends Seeder
{
    /**
     * ArticleServiceテーブルに初期データを投入します。
     *
     * ArticleServiceモデルを利用して、「Qiita」と「Zenn」という名前のレコードをデータベースに作成します。
     */
    public function run()
    {
        ArticleService::create(['name' => 'Qiita']);
        ArticleService::create(['name' => 'Zenn']);
    }
}
