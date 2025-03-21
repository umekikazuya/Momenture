<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\FeaturedArticle;
use Illuminate\Database\Seeder;

class FeaturedArticleSeeder extends Seeder
{
    public function run()
    {
        // 記事が無い場合はスキップ
        if (Article::count() === 0) {
            $this->command->warn('記事が存在しないため、FeaturedArticleは作成されませんでした。');

            return;
        }

        // 記事をランダムに10件ピックアップして注目記事として登録
        $articles = Article::query()
            ->limit(10)
            ->get();

        foreach ($articles as $index => $article) {
            FeaturedArticle::create([
                'article_id' => $article->id,
                'priority' => $index + 1,
                'is_active' => true,
            ]);
        }
    }
}
