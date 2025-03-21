<?php

namespace Tests\Feature\Api;

use App\Models\Article;
use App\Models\ArticleService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(); // Seederでデータ投入
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function 記事一覧_apiが200を返しデータ構造も正しい()
    {
        $response = $this->getJson('/backend/articles');

        $response->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => ['id', 'title', 'status', 'service', 'link', 'created_at', 'updated_at'],
                    ],
                ]
            );
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function 記事作成_apiが201で返る()
    {
        $service = ArticleService::first(); // SeederのQiita

        $payload = [
            'title' => 'APIテスト記事',
            'status' => 'draft',
            'service' => $service->id,
            'link' => 'https://example.com/test',
        ];

        $response = $this->postJson('/backend/articles', $payload);

        $response->assertStatus(201)
            ->assertJsonFragment(
                [
                    'title' => 'APIテスト記事',
                    'status' => 'draft',
                ]
            );
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function 不正なデータでバリデーションエラーになる()
    {
        $payload = [
            'title' => '', // タイトル空
            'status' => 'invalid_status', // 想定外
            'service' => 9999, // 存在しない
        ];

        $response = $this->postJson('/backend/articles', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'status', 'service']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function 記事更新_apiが200で返り内容が更新される()
    {
        $article = Article::first();
        $newTitle = '更新後のタイトル';

        $response = $this->putJson(
            "/api/articles/{$article->id}", [
                'title' => $newTitle,
                'link' => 'https://example.com/updated',
            ]
        );

        $response->assertStatus(200)
            ->assertJsonFragment(
                [
                    'title' => $newTitle,
                    'link' => 'https://example.com/updated',
                ]
            );
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function 記事削除_apiが204で返る()
    {
        $article = Article::first();

        $response = $this->deleteJson("/api/articles/{$article->id}");

        $response->assertStatus(204);

        // 削除されていること確認 (soft delete)
        $this->assertSoftDeleted('articles', ['id' => $article->id]);
    }
}
