<?php

namespace App\Application\UseCases\Article;

use App\Application\DTOs\CreateArticleInput;
use App\Domain\Entities\Article;
use App\Domain\Repositories\ArticleRepositoryInterface;

class CreateArticleUseCase implements CreateArticleUseCaseInterface
{
    /**
     * CreateArticleUseCaseクラスのコンストラクタ。
     *
     * ArticleRepositoryInterface のインスタンスを受け取り、記事作成に必要なリポジトリを初期化します。
     */
    public function __construct(
        private ArticleRepositoryInterface $articleRepository
    ) {
    }

    /**
     * 指定された記事作成情報に基づいて記事を生成し、リポジトリに保存後、生成した記事を返します。
     *
     * 渡されたCreateArticleInput DTOから記事のタイトル、リンク、状態、サービスを取得し、
     * 作成日時および更新日時を現在の日時で初期化したArticleオブジェクトを生成します。
     * その記事はリポジトリに保存され、作成されたArticleインスタンスが返されます。
     *
     * @param CreateArticleInput $dto 記事作成に必要な情報を格納したDTO。
     * @return Article 作成されたArticleオブジェクト。
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
