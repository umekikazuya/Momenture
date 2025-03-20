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
use App\Application\UseCases\ArticleService\CreateUseCase;
use App\Application\UseCases\ArticleService\CreateUseCaseInterface;
use App\Application\UseCases\ArticleService\DeleteUseCase;
use App\Application\UseCases\ArticleService\DeleteUseCaseInterface;
use App\Application\UseCases\ArticleService\FindAllUseCase;
use App\Application\UseCases\ArticleService\FindAllUseCaseInterface;
use App\Application\UseCases\ArticleService\FindByIdUseCase;
use App\Application\UseCases\ArticleService\FindByIdUseCaseInterface;
use App\Application\UseCases\ArticleService\UpdateUseCase;
use App\Application\UseCases\ArticleService\UpdateUseCaseInterface;
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
     * アプリケーションの各種サービスを登録し、依存性注入の設定を行う。
     *
     * このメソッドは、フィードの取得およびパースサービス、DynamoDbClientのシングルトンインスタンス、
     * 記事リポジトリ、そして記事管理に関連する各ユースケース（作成、更新、削除、復元、検索、状態変更）の
     * インターフェースと実装のバインディングをコンテナに登録し、アプリケーション全体での依存性解決を可能にします。
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
        $this->app->bind(
            \App\Domain\Repositories\ArticleServiceRepositoryInterface::class,
            \App\Infrastructure\Repositories\EloquentArticleServiceRepository::class
        );
        $this->app->bind(CreateArticleUseCaseInterface::class, CreateArticleUseCase::class);
        $this->app->bind(UpdateArticleUseCaseInterface::class, UpdateArticleUseCase::class);
        $this->app->bind(DeleteArticleUseCaseInterface::class, DeleteArticleUseCase::class);
        $this->app->bind(RestoreArticleUseCaseInterface::class, RestoreArticleUseCase::class);
        $this->app->bind(FindArticleByIdUseCaseInterface::class, FindArticleByIdUseCase::class);
        $this->app->bind(FindArticlesUseCaseInterface::class, FindArticlesUseCase::class);
        $this->app->bind(ChangeArticleStatusUseCaseInterface::class, ChangeArticleStatusUseCase::class);

        $this->app->bind(CreateUseCaseInterface::class, CreateUseCase::class);
        $this->app->bind(UpdateUseCaseInterface::class, UpdateUseCase::class);
        $this->app->bind(FindByIdUseCaseInterface::class, FindByIdUseCase::class);
        $this->app->bind(FindAllUseCaseInterface::class, FindAllUseCase::class);
        $this->app->bind(DeleteUseCaseInterface::class, DeleteUseCase::class);
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
