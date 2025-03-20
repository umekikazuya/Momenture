<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * アプリケーションのデータベースを初期化します。
     *
     * このメソッドは、ArticleServiceSeeder、TagSeeder、および ArticleSeeder を順次実行し、
     * 必要な初期データを登録します。
     */
    public function run(): void
    {
        $this->call([
            ArticleServiceSeeder::class,
            TagSeeder::class,
            ArticleSeeder::class,
        ]);
    }
}
