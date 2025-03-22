<?php

namespace Database\Factories;

use App\Models\ArticleService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * 記事モデルのデフォルト状態を返します。
     *
     * このメソッドはfakerライブラリとArticleServiceからのデータを利用して、記事の各フィールドの初期値を定義します。
     * - 'title': 5単語からなるランダムな文章
     * - 'status': 'draft'または'published'のいずれか
     * - 'article_service_id': ランダムなArticleServiceのID（記事サービスが存在しない場合は1）
     * - 'link': ランダムなURL
     *
     * @return array<string, mixed> 記事モデルのデフォルト状態
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(5),
            'status' => $this->faker->randomElement(['draft', 'published']),
            'article_service_id' => ArticleService::inRandomOrder()->first()?->id ?? 1,
            'link' => $this->faker->url(),
        ];
    }
}
