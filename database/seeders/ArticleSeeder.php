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
     * 50件の記事を生成し、各記事にランダムに1〜3個のタグを紐付けます。
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
