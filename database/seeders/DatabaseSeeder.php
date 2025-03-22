<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * アプリケーションのデータベースに初期データを投入。
     *
     * このメソッドは、ArticleServiceSeeder、TagSeeder、ArticleSeeder、および FeaturedArticleSeeder を順に呼び出し、
     * アプリケーションの主要コンテンツに必要な初期データをシード。
     *
     * 実行順序の依存関係:
     * 1. ArticleServiceSeeder - 記事サービスの基本データを作成
     * 2. TagSeeder - タグの基本データを作成
     * 3. ArticleSeeder - 記事を作成し、タグと関連付け（TagSeederに依存）
     * 4. FeaturedArticleSeeder - 注目記事を設定（ArticleSeederに依存）
     */
    public function run(): void
    {
        $this->call([
            ArticleServiceSeeder::class,
            TagSeeder::class,
            ArticleSeeder::class,
            FeaturedArticleSeeder::class,
        ]);
    }
}
