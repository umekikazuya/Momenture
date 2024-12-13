<?php

namespace App\Presentation\Resources\ArticleResource\Pages;

use App\Presentation\Resources\ArticleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateArticle extends CreateRecord
{
    protected static string $resource = ArticleResource::class;
}
