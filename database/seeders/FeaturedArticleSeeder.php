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
        // 既存の注目記事をクリア
        FeaturedArticle::query()->delete();
        $this->command->info('既存の注目記事をクリアしました。');
        // 記事をランダムに10件ピックアップして注目記事として登録
        $articles = Article::query()
            ->orderBy('created_at', 'desc') // 最新の記事を優先
            ->limit(10)
            ->get();
        $count = 0;
        foreach ($articles as $index => $article) {
            try {
                FeaturedArticle::create([
                    'article_id' => $article->id,
                    'priority' => $index + 1,
                    'is_active' => true,
                ]);
                $count++;
            } catch (\Exception $e) {
                $this->command->error("記事ID: {$article->id} の注目記事登録に失敗しました: {$e->getMessage()}");
            }
        }

        $this->command->info("{$count}件の注目記事を登録しました。");
    }
}
