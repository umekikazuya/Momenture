<?php

namespace App\Application\UseCases\Article;

use App\Application\DTOs\CreateArticleInput;
use App\Domain\Entities\Article;
use App\Domain\Repositories\ArticleRepositoryInterface;

class CreateArticleUseCase implements CreateArticleUseCaseInterface
{
    /**
     * CreateArticleUseCaseクラスの新しいインスタンスを初期化する。
     */
    public function __construct(
        private ArticleRepositoryInterface $articleRepository
    ) {
    }

    /**
     * 指定の入力 DTO を基に新しい記事を作成し、リポジトリに保存した上で返します。
     *
     * DTO からタイトル、リンク、ステータス、およびサービス情報を取得し、新規 Article インスタンスを生成します。
     * 作成日時と更新日時は現在時刻で初期化され、その後リポジトリに保存されます。
     *
     * @param CreateArticleInput $dto 記事作成に必要なデータ (タイトル、リンク、ステータス、サービス情報) を含む DTO
     * @return Article 作成された記事オブジェクト
     */
    public function execute(
        CreateArticleInput $dto
    ): Article {
        $article = new Article(
            id: 0,
            title: $dto->title,
            link: $dto->link,
            status: $dto->status,
            service: $dto->service,
            createdAt: new \DateTimeImmutable(),
            updatedAt: new \DateTimeImmutable(),
        );
        $this->articleRepository->save($article);
        return $article;
    }
}
