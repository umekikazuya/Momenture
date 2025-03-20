<?php

namespace App\Application\UseCases\Article;

use App\Application\DTOs\CreateArticleInput;
use App\Domain\Entities\Article;
use App\Domain\Repositories\ArticleRepositoryInterface;

class CreateArticleUseCase implements CreateArticleUseCaseInterface
{
    /**
     * コンストラクタ
     *
     * 記事リポジトリのインスタンスを受け取り、記事作成ユースケースの初期化を行います。
     */
    public function __construct(
        private ArticleRepositoryInterface $articleRepository
    ) {
    }

    /**
     * 入力DTOから記事を生成し、リポジトリに保存された記事を返す。
     *
     * CreateArticleInput DTOから記事作成に必要な情報（タイトル、リンク、ステータス、サービス）を取得し、
     * 新しいArticleオブジェクトを生成します。生成時には記事IDが0に初期化され、作成日時および更新日時に現在の日時が設定されます。
     * 生成された記事は記事リポジトリに保存され、その結果のArticleオブジェクトが返されます。
     *
     * @param CreateArticleInput $dto 記事作成に必要な情報を持つDTO
     *
     * @return Article 保存された記事オブジェクト
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
