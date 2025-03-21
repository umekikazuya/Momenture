<?php

namespace App\Application\UseCases\ArticleService;

use App\Domain\Repositories\ArticleServiceRepositoryInterface;

class FindAllUseCase implements FindAllUseCaseInterface
{
    /**
     * コンストラクタ
     *
     * 記事一覧の取得に必要な記事サービスリポジトリを注入し、ユースケースの初期化を行います。
     */
    public function __construct(private ArticleServiceRepositoryInterface $repository)
    {
    }

    /**
     * 記事サービスの全件を取得する。
     *
     * リポジトリから記事サービス情報をすべて取得し、配列で返します。
     * 取得中にエラーが発生した場合、元の例外を含むRuntimeExceptionがスローされます。
     *
     * @return array 取得された記事サービス情報の配列
     * @throws \RuntimeException 記事サービスの取得中にエラーが発生した場合
     */
    public function execute(): array
    {
        try {
            return $this->repository->findAll();
        } catch (\Exception $e) {
            throw new \RuntimeException('記事サービスの取得中にエラーが発生しました', 0, $e);
        }
    }
}
