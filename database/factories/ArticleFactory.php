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
     * Define the model's default state.
     *
     * @return array<string, mixed>
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
