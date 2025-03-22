<?php

namespace Tests\Unit\Application\UseCases\Article;

use App\Application\Dtos\UpdateArticleInput;
use App\Application\UseCases\Article\UpdateArticleUseCase;
use App\Domain\Entities\Article;
use App\Domain\Entities\ArticleService;
use App\Domain\Enums\ArticleStatus;
use App\Domain\Repositories\ArticleRepositoryInterface;
use App\Domain\ValueObjects\ArticleLink;
use App\Domain\ValueObjects\ArticleServiceId;
use App\Domain\ValueObjects\ArticleServiceName;
use App\Domain\ValueObjects\ArticleTitle;
use Mockery;
use PHPUnit\Framework\TestCase;

class UpdateArticleUseCaseTest extends TestCase
{
    private $repository;

    private $useCase;

    private $article;

    protected function setUp(): void
    {
        $this->repository = Mockery::mock(ArticleRepositoryInterface::class);
        $this->useCase = new UpdateArticleUseCase($this->repository);

        $this->article = new Article(
            id: 1,
            title: new ArticleTitle('元のタイトル'),
            status: ArticleStatus::DRAFT,
            service: new ArticleService(new ArticleServiceId(1), new ArticleServiceName('Qiita')),
            createdAt: new \DateTimeImmutable,
            updatedAt: new \DateTimeImmutable
        );
    }

    public function test_記事を編集できる()
    {
        $newTitle = new ArticleTitle('変更後のタイトル');
        $newLink = new ArticleLink('https://updated.com');

        $this->repository
            ->shouldReceive('findById')
            ->with(1)
            ->andReturn($this->article);

        $this->repository
            ->shouldReceive('save')
            ->once();

        $input = new UpdateArticleInput(1, $newTitle, $newLink, null);
        $updatedArticle = $this->useCase->execute($input);

        $this->assertEquals('変更後のタイトル', $updatedArticle->title()->value());
        $this->assertEquals('https://updated.com', $updatedArticle->link()->value());
    }

    public function test_存在しない記事の編集で例外が発生する()
    {
        $this->repository
            ->shouldReceive('findById')
            ->with(999)
            ->andReturn(null);

        $this->expectException(\DomainException::class);

        $input = new UpdateArticleInput(999, new ArticleTitle('テスト'));
        $this->useCase->execute($input);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
