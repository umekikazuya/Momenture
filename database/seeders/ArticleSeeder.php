<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\ArticleService;
use App\Models\Tag;

class ArticleSeeder extends Seeder
{
    /**
     * データベースにサンプル記事データを挿入するシーダーメソッドです。
     *
     * このメソッドは、最初の ArticleService レコードからサービスIDを取得し、そのIDを用いて
     * 「シーディング記事サンプル」というタイトルの公開済み記事を作成します。作成した記事には
     * リンクが設定され、全てのタグ（Tag レコード）が記事に関連付けられます。
     */
    public function run()
    {
        // 最初のサービスを取得
        $serviceId = ArticleService::first()->id;

        /** @var Article $article */
        $article = Article::create([
            'title' => 'シーディング記事サンプル',
            'status' => 'published',
            'article_service_id' => $serviceId,
            'link' => 'https://example.com',
        ]);

        // タグを1つ以上付与
        $tagIds = Tag::pluck('id')->toArray();
        $article->tags()->attach($tagIds);
    }
}
