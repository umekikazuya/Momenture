<?php

namespace App\Http\Requests\ArticleService;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * すべてのリクエストを常に認可します。
     *
     * このメソッドは、認証が不要な場合に全リクエストを許可するため、常に true を返します。
     *
     * @return bool 常に true
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * リクエストに対するバリデーションルールを返します。
     *
     * このメソッドは、ArticleServiceのリクエストに適用されるバリデーションルールを定義し、
     * 'name'フィールドが必須、文字列、かつ最大255文字であることを指定します。
     *
     * @return array バリデーションルールの連想配列
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }

    /**
     * バリデーションエラーメッセージを定義します。
     *
     * フォームリクエストの検証が失敗した際に返されるエラーメッセージを、各ルールに対してカスタム設定します。
     * 現在は、サービス名の必須入力と文字数制限に関するエラーメッセージが含まれます。
     *
     * @return array フォーム検証エラーメッセージの連想配列
     */
    public function messages(): array
    {
        return [
            'name.required' => 'サービス名は必須です。',
            'name.max' => 'サービス名は100文字以内で入力してください。',
        ];
    }
}
