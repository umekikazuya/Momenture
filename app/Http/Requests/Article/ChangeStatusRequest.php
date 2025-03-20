<?php

declare(strict_types=1);

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangeStatusRequest extends FormRequest
{
    /**
     * リクエストの認証を実施します。
     *
     * このメソッドは常に true を返し、全てのユーザーに対してリクエストを許可します。
     *
     * @return bool 常に true を返します。
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * バリデーションルールを返します。
     *
     * このメソッドは、リクエストの「new_status」フィールドが必須であり、ArticleStatus 列挙体に定義される値のいずれかであることを検証するルールを提供します。
     *
     * @return array バリデーションルールの配列
     */
    public function rules(): array
    {
        return [
            'new_status' => ['required', Rule::in(collect(\App\Domain\Enums\ArticleStatus::cases())->map->value->all())],
        ];
    }
}
