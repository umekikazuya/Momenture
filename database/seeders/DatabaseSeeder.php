<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * アプリケーションのデータベースに初期データをシードする。
     *
     * このメソッドは ArticleServiceSeeder、TagSeeder、ArticleSeeder を呼び出し、
     * アプリケーションに必要な記事およびタグ関連の初期データを挿入する。
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
