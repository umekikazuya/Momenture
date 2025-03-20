<?php

declare(strict_types=1);

namespace App\Application\UseCases\Article;

use App\Application\DTOs\UpdateArticleInput;
use App\Domain\Entities\Article;
use App\Domain\Repositories\ArticleRepositoryInterface;

class UpdateArticleUseCase implements UpdateArticleUseCaseInterface
{
    /**
 * コンストラクタ。
 *
 * 記事リポジトリを受け取り、記事データへのアクセスおよび更新処理のための依存性注入を行います。
 */
public function __construct(private ArticleRepositoryInterface $articleRepository) {}

    /**
     * 指定された入力に基づいて記事を更新します。
     *
     * 入力の ID を元に記事を取得し、存在しない場合は DomainException をスローします。
     * 入力にタイトル、リンク、またはサービス情報が含まれている場合、それぞれの記事の属性を更新し、
     * 更新後の記事をリポジトリへ保存して返却します。
     *
     * @param UpdateArticleInput $input 更新対象の記事情報と更新内容を含む入力データ。
     * @return Article 更新された記事オブジェクト。
     *
     * @throws \DomainException 指定された ID の記事が存在しない場合にスローされます。
     */
    public function execute(
        UpdateArticleInput $input,
    ): Article {
        $article = $this->articleRepository->findById($input->id);

        if (! $article) {
            throw new \DomainException("記事が見つかりません。ID: {$input->id}");
        }

        if ($input->title !== null) {
            $article->updateTitle($input->title);
        }

        if ($input->link !== null) {
            $article->updateLink($input->link);
        }

        if ($input->service !== null) {
            $article->updateArticleService($input->service);
        }

        $this->articleRepository->save($article);

        return $article;
    }
}
