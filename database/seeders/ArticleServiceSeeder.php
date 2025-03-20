<?php

namespace Database\Seeders;

use App\Models\ArticleService;
use Illuminate\Database\Seeder;

class ArticleServiceSeeder extends Seeder
{
    /**
     * データベースに初期データを挿入します。
     *
     * ArticleService モデルを用いて、名前が「Qiita」と「Zenn」のレコードをそれぞれ作成します。
     */
    public function run()
    {
        ArticleService::create(['name' => 'Qiita']);
        ArticleService::create(['name' => 'Zenn']);
    }
}
