<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * データベースにサンプル記事データを登録します。
     *
     * 最初のサービスのIDを取得し、その情報を基に記事を作成します。
     * 作成された記事には、全タグが紐付けられます。
     */
    public function run()
    {
        Article::factory()
            ->count(50)
            ->create()
            ->each(function ($article) {
                // 全タグをランダムに1〜3個付与
                $tagIds = Tag::inRandomOrder()->limit(rand(1, 3))->pluck('id');
                $article->tags()->attach($tagIds);
            });
    }
}
