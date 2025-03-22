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
        $services = [
            'Qiita',
            'Zenn',
        ];
        foreach ($services as $service) {
            ArticleService::query()->updateOrCreate([
                'name' => $service,
            ]);
        }
    }
}
