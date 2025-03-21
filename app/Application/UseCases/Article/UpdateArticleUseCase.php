<?php

declare(strict_types=1);

namespace App\Application\UseCases\Article;

use App\Application\DTOs\UpdateArticleInput;
use App\Domain\Entities\Article;
use App\Domain\Repositories\ArticleRepositoryInterface;

class UpdateArticleUseCase implements UpdateArticleUseCaseInterface
{
    /**
     * ArticleRepositoryInterface を内部プロパティとして設定し、記事の更新処理に利用します。
     */
    public function __construct(private ArticleRepositoryInterface $articleRepository)
    {
    }

    /**
     * 記事を更新し、更新後のArticleオブジェクトを返します。
     *
     * このメソッドは、与えられたUpdateArticleInputオブジェクトを用いて記事を取得し、存在しない場合はDomainExceptionをスローします。
     * 入力されたタイトル、リンク、またはサービスが非nullの場合、それぞれの記事の属性を更新します。
     * 更新後、記事はリポジトリに保存され、更新済みの記事オブジェクトが返されます。
     *
     * @param  UpdateArticleInput $input 更新対象記事の情報を含む入力オブジェクト。記事IDと更新する可能性のあるフィールドが含まれます。
     * @return Article 更新されたArticleオブジェクト。
     *
     * @throws DomainException 指定されたIDのArticleが存在しない場合にスローされます。
     */
    public function execute(
        UpdateArticleInput $input,
    ): Article {
        $entity = $this->articleRepository->findById($input->id);

        if (! $entity) {
            throw new \DomainException("記事が見つかりません。ID: {$input->id}");
        }

        if ($input->title !== null) {
            $entity->updateTitle($input->title);
        }

        if ($input->link !== null) {
            $entity->updateLink($input->link);
        }

        if ($input->service !== null) {
            $entity->updateArticleService($input->service);
        }

        $this->articleRepository->save($entity);

        return $entity;
    }
}
