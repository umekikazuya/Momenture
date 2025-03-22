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
        // 利用可能なタグIDをあらかじめ取得
        $allTagIds = Tag::pluck('id')->toArray();

        // タグが存在しない場合の処理
        if (empty($allTagIds)) {
            $this->command->warn('タグが存在しないため、記事のタグ付けは行いません。');
        }
        Article::factory()
            ->count(50)
            ->create()
            ->each(function ($article) {
                // タグが存在しない場合は処理をスキップ
                if (empty($allTagIds)) {
                    return;
                }
                $tagCount = min(rand(1, 3), count($allTagIds));
                $selectedTagIds = array_rand(array_flip($allTagIds), $tagCount);
                $tagIds = is_array($selectedTagIds) ? $selectedTagIds : [$selectedTagIds];
                $article->tags()->attach($tagIds);
            });
    }
}
