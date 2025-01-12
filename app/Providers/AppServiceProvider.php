<?php

namespace App\Providers;

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
