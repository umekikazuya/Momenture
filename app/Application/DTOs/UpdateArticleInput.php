<?php

namespace App\Application\Dtos;

use App\Domain\Entities\ArticleService;
use App\Domain\Enums\ArticleStatus;
use App\Domain\ValueObjects\ArticleLink;
use App\Domain\ValueObjects\ArticleTitle;
use App\Http\Requests\Article\UpdateRequest;

class UpdateArticleInput
{
    public function __construct(
        public int $id,
        public ?ArticleTitle $title = null,
        public ?ArticleLink $link = null,
        public ?ArticleStatus $status = null,
        public ?ArticleService $service = null,
    ) {
    }

    public static function fromRequest(int $id, UpdateRequest $request): self
    {
        return new self(
            $id,
            $request->filled('title') ? new ArticleTitle($request->title) : null,
            $request->filled('link') ? new ArticleLink($request->link) : null,
            $request->filled('status') ? ArticleStatus::from($request->status) : null,
            $request->filled('service_id')
                ? new ArticleService($request->service_id, '')
                : null
        );
    }
}
