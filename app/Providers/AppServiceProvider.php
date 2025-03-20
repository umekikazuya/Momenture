<?php

namespace App\Providers;

use App\Application\UseCases\Article\ChangeArticleStatusUseCase;
use App\Application\UseCases\Article\ChangeArticleStatusUseCaseInterface;
use App\Application\UseCases\Article\CreateArticleUseCase;
use App\Application\UseCases\Article\CreateArticleUseCaseInterface;
use App\Application\UseCases\Article\DeleteArticleUseCase;
use App\Application\UseCases\Article\DeleteArticleUseCaseInterface;
use App\Application\UseCases\Article\FindArticleByIdUseCase;
use App\Application\UseCases\Article\FindArticleByIdUseCaseInterface;
use App\Application\UseCases\Article\FindArticlesUseCase;
use App\Application\UseCases\Article\FindArticlesUseCaseInterface;
use App\Application\UseCases\Article\RestoreArticleUseCase;
use App\Application\UseCases\Article\RestoreArticleUseCaseInterface;
use App\Application\UseCases\Article\UpdateArticleUseCase;
use App\Application\UseCases\Article\UpdateArticleUseCaseInterface;
use App\Services\Contracts\FeedFetcherInterface;
use App\Services\Contracts\FeedParserInterface;
use App\Services\FeedFetcherService;
use App\Services\FeedQiitaParserService;
use App\Services\FeedZennParserService;
use Aws\DynamoDb\DynamoDbClient;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(FeedFetcherInterface::class, FeedFetcherService::class);
        $this->app->singleton(FeedParserInterface::class, FeedQiitaParserService::class);
        $this->app->singleton(FeedParserInterface::class, FeedZennParserService::class);
        $this->app->singleton(DynamoDbClient::class, function ($app) {
            return new DynamoDbClient([
                'region' => env('AWS_DEFAULT_REGION', 'ap-northeast-1'),
                'version' => 'latest',
                'endpoint' => env('APP_ENV') === 'local' ? env('DYNAMODB_ENDPOINT') : null,
                'credentials' => [
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
            ]);
        });
        $this->app->bind(
            \App\Domain\Repositories\ArticleRepositoryInterface::class,
            \App\Infrastructure\Repositories\EloquentArticleRepository::class
        );
        $this->app->bind(CreateArticleUseCaseInterface::class, CreateArticleUseCase::class);
        $this->app->bind(UpdateArticleUseCaseInterface::class, UpdateArticleUseCase::class);
        $this->app->bind(DeleteArticleUseCaseInterface::class, DeleteArticleUseCase::class);
        $this->app->bind(RestoreArticleUseCaseInterface::class, RestoreArticleUseCase::class);
        $this->app->bind(FindArticleByIdUseCaseInterface::class, FindArticleByIdUseCase::class);
        $this->app->bind(FindArticlesUseCaseInterface::class, FindArticlesUseCase::class);
        $this->app->bind(ChangeArticleStatusUseCaseInterface::class, ChangeArticleStatusUseCase::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
