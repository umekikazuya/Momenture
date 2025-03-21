<?php

declare(strict_types=1);

namespace App\Application\UseCases\ArticleService;

use App\Domain\Entities\ArticleService;
use App\Domain\Repositories\ArticleServiceRepositoryInterface;
use App\Domain\ValueObjects\ArticleServiceId;
use App\Domain\ValueObjects\ArticleServiceName;

class CreateUseCase implements CreateUseCaseInterface
{
    /**
     * CreateUseCaseクラスの新しいインスタンスを初期化する。
     *
     * 指定された記事サービスリポジトリを内部プロパティに設定し、記事サービスの作成および永続化に必要な依存関係を注入します。
     */
    public function __construct(
        private ArticleServiceRepositoryInterface $articleRepository
    ) {
    }

    /**
     * 指定された名前を持つ新しい記事サービスオブジェクトを作成し、リポジトリに保存します。
     *
     * 提供された名前からArticleServiceNameを生成し、初期ID（0）を用いてArticleServiceインスタンスを作成します。
     * 作成された記事サービスは、記事リポジトリに保存され、そのインスタンスが返されます。
     *
     * @param  string $name 作成する記事サービスの名前
     * @return ArticleService 作成された記事サービスオブジェクト
     */
    public function execute(string $name): ArticleService
    {
        $article = new ArticleService(
            id: new ArticleServiceId(0),
            name: new ArticleServiceName($name),
        );
        $this->articleRepository->create($article);
        return $article;
    }
}
