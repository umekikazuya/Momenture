<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * リクエストの認可を常に許可します。
     *
     * このメソッドは常にtrueを返し、全ユーザーに対してリクエストを実行可能とします。
     *
     * @return bool 常にtrue
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * 更新リクエスト用のバリデーションルールを返します。
     *
     * このメソッドは、記事更新時に適用される各フィールドのバリデーションルールを定義した連想配列を返します。
     * - `title`: 文字列型で最大255文字まで。値が存在しなくても可（nullable）。
     * - `link`: URL形式かつnullable。
     * - `service`: 整数型で、`article_services`テーブルの有効なIDに存在する必要がある。nullable。
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
     * 各バリデーションルールに対応するエラーメッセージを定義しており、ユーザーに対して直感的なフィードバックを提供します。
     *
     * @return array 各ルール (例: 'title.max', 'service.exists', 'link.url') に対応するエラーメッセージの連想配列。
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
