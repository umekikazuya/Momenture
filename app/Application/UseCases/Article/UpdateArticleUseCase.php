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
 * ArticleRepositoryInterface を受け取り、記事データの取得および更新に必要な依存性を注入します。
 */
public function __construct(private ArticleRepositoryInterface $articleRepository) {}

    /**
     * 指定された入力データに基づき記事を更新し、更新された記事を返します。
     *
     * 渡された UpdateArticleInput オブジェクトの ID を使用して記事を検索し、記事が存在しない場合は DomainException をスローします。
     * 入力内のタイトル、リンク、サービスが null でない場合、それぞれの記事属性を更新し、更新後の記事を保存します。
     *
     * @param UpdateArticleInput $input 更新対象の記事情報を含むオブジェクト
     * @return Article 更新済みの記事オブジェクト
     * @throws DomainException 指定された ID の記事が存在しない場合
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
