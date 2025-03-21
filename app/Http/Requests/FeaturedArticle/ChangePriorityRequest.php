<?php

declare(strict_types=1);

namespace App\Http\Requests\FeaturedArticle;

use Illuminate\Foundation\Http\FormRequest;

class ChangePriorityRequest extends FormRequest
{
    /**
     * リクエストのバリデーションルールを返す。
     *
     * このメソッドは、'priority' フィールドが必須であり、整数であり、1以上の値であることを検証するルールを返します。
     *
     * @return array リクエスト検証ルールの配列
     */
    public function rules(): array
    {
        return [
            'priority' => 'required|integer|min:1',
        ];
    }

    /**
     * 全てのユーザーに対してリクエストの認証を許可する。
     *
     * このメソッドは常に true を返すため、すべてのユーザーがリクエストを実行できます。
     *
     * @return bool 常に true
     */
    public function authorize(): bool
    {
        return true;
    }
}
