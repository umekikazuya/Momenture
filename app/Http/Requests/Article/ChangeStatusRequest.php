<?php

declare(strict_types=1);

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangeStatusRequest extends FormRequest
{
    /**
     * リクエストが常に許可されることを示す。
     *
     * このメソッドは常に true を返すため、すべてのユーザーに対してリクエストが有効であることを保証します。
     *
     * @return bool 常に true
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * リクエストに適用される検証ルールを返します。
     *
     * このメソッドは、`new_status` フィールドが必須であり、`ArticleStatus` Enumに定義された値のいずれかであることを要求する検証ルールを定義します。
     *
     * @return array 検証ルールの配列
     */
    public function rules(): array
    {
        return [
            'new_status' => ['required', Rule::in(collect(\App\Domain\Enums\ArticleStatus::cases())->map->value->all())],
        ];
    }
}
