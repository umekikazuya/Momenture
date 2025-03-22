<?php

namespace Tests\Unit\Domain\Entities;

use App\Domain\Entities\ArticleService;
use App\Domain\ValueObjects\ArticleServiceId;
use App\Domain\ValueObjects\ArticleServiceName;
use PHPUnit\Framework\TestCase;
use TypeError;

class ArticleServiceTest extends TestCase
{
    public function test_it_can_get_id_and_name(): void
    {
        $id = new ArticleServiceId(1);
        $name = new ArticleServiceName('Test Service');
        $articleService = new ArticleService($id, $name);

        $this->assertSame($id, $articleService->id());
        $this->assertSame($name, $articleService->name());
    }

    public function test_it_can_update_name(): void
    {
        $id = new ArticleServiceId(1);
        $name = new ArticleServiceName('Test Service');
        $newName = new ArticleServiceName('Updated Service');
        $articleService = new ArticleService($id, $name);

        $articleService->updateName($newName);

        $this->assertSame($newName, $articleService->name());
    }

    public function test_it_throws_exception_when_initialized_with_null(): void
    {
        $this->expectException(TypeError::class);

        new ArticleService(null, null);
    }

    public function test_it_throws_exception_when_updating_name_with_invalid_type(): void
    {
        $id = new ArticleServiceId(1);
        $name = new ArticleServiceName('Test Service');
        $articleService = new ArticleService($id, $name);

        $this->expectException(TypeError::class);

        $articleService->updateName('Invalid Name');
    }
}
