<?php

declare(strict_types=1);

namespace App\Http\Requests\ArticleService;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * ユーザーがリクエストを実行する権限があるかを確認します。
     *
     * このメソッドは常にtrueを返すため、すべてのユーザーに対してリクエスト実行が許可されます。
     *
     * @return bool 常にtrue
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * リクエストのバリデーションルールを返却します。
     *
     * このメソッドは、リクエストパラメータ「name」が任意で、文字列であり、最大255文字であることを定義するバリデーションルールの連想配列を返します。
     *
     * @return array バリデーションルールの連想配列
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }
}
