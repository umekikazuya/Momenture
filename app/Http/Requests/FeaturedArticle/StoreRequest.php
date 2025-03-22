<?php

declare(strict_types=1);

namespace App\Http\Requests\FeaturedArticle;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * HTTPリクエストのバリデーションルールを定義して返します。
     *
     * ルール:
     * - `article_id`: 必須、整数、および `articles` テーブルに存在するかをチェックします。
     * - `priority`: 必須、整数で、最低値は1とします。
     *
     * @return array バリデーションルールの連想配列
     */
    public function rules(): array
    {
        return [
            'article_id' => 'required|integer|exists:articles,id',
            'priority' => 'required|integer|min:1',
        ];
    }

    /**
     * 常にリクエストを承認します。
     *
     * すべてのユーザーのリクエストを許可するため、常にtrueを返します。
     *
     * @return bool 常にtrue
     */
    public function authorize(): bool
    {
        return true;
    }
}
