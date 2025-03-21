<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * アプリケーションのデータベースに初期データを投入する。
     *
     * このメソッドは、ArticleServiceSeeder、TagSeeder、ArticleSeeder、および FeaturedArticleSeeder を順に呼び出し、
     * アプリケーションの主要コンテンツに必要な初期データをシードします。
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
