<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * リクエストが常に承認されることを示します。
     *
     * このメソッドは、すべてのリクエストに対して認可を返すため、常に true を返します。
     *
     * @return bool 常に true
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * 記事更新リクエストのバリデーションルールを定義します。
     *
     * 各フィールドに以下のルールを適用します:
     * - title: null または文字列で、最大255文字まで許容。
     * - link: null または有効なURL形式。
     * - service: null または整数で、article_servicesテーブルに存在する有効なIDである必要があります。
     *
     * @return array バリデーションルールの連想配列
     */
    public function rules(): array
    {
        return [
            'title' => 'nullable|string|max:255',
            'link' => 'nullable|url',
            'service' => 'nullable|integer|exists:article_services,id',

        ];
    }

    /**
     * フォームリクエスト用のカスタムバリデーションエラーメッセージを返します。
     *
     * このメソッドは、バリデーションに失敗した際に各フィールドに対して表示されるエラーメッセージの配列を返却します。
     *
     * @return array カスタムエラーメッセージの配列
     */
    public function messages(): array
    {
        return [
            'title.max' => 'タイトルは255文字以内で入力してください。',
            'service.exists' => '選択されたサービスは無効です。',
            'link.url' => 'リンクは有効なURLを入力してください。',
        ];
    }
}
