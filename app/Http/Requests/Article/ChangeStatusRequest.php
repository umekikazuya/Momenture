<?php

declare(strict_types=1);

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangeStatusRequest extends FormRequest
{
    /**
     * 常にリクエストの許可を返します。
     *
     * このメソッドは全てのリクエストを許可するため、常に true を返します。
     *
     * @return bool 常に true
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * リクエストの検証ルールを定義する。
     *
     * このメソッドは new_status フィールドに対して必須条件および
     * ArticleStatus enum に定義された値のいずれかであることを検証するルールを返します。
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
