<?php

namespace App\Application\DTOs;

use App\Domain\Entities\ArticleService;
use App\Domain\Enums\ArticleStatus;
use App\Domain\ValueObjects\ArticleLink;
use App\Domain\ValueObjects\ArticleTitle;
use App\Http\Requests\Article\StoreRequest;

final class CreateArticleInput
{
    public function __construct(
        public readonly ArticleTitle $title,
        public readonly ArticleLink $link,
        public readonly ArticleStatus $status,
        public readonly ArticleService $service
    ) {}

    public static function fromRequest(StoreRequest $request): self
    {
        return new self(
            new ArticleTitle($request->title),
            new ArticleLink($request->link),
            ArticleStatus::from($request->status),
            new ArticleService($request->service, '')
        );
    }
}
