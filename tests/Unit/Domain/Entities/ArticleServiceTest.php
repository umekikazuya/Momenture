<?php

namespace Tests\Unit\Domain\Entities;

use App\Domain\Entities\ArticleService;
use PHPUnit\Framework\TestCase;

class ArticleServiceTest extends TestCase
{
    public function test_サービスを作成できる()
    {
        $service = new ArticleService(1, 'Qiita');

        $this->assertInstanceOf(ArticleService::class, $service);
        $this->assertSame(1, $service->id());
        $this->assertSame('Qiita', $service->name());
    }
}
