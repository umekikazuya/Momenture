<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * リクエストが許可されているかどうかを判定します。
     *
     * このメソッドは常に true を返すため、全てのリクエストが承認されます。
     *
     * @return bool 常に true を返します。
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * フォームリクエストのバリデーションルールを返却します。
     *
     * 各フィールドの検証条件は以下の通りです:
     * - `title`: NULL許容、文字列型かつ最大255文字
     * - `link`: NULL許容、有効なURL形式
     * - `service`: NULL許容、整数型かつ `article_services` テーブルに存在するIDである必要があります
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
     * バリデーションエラー時のカスタムメッセージを返す。
     *
     * このメソッドは、タイトルの最大文字数、サービスの存在確認、およびリンクのURL形式に関する
     * バリデーションエラーメッセージを定義した配列を返します。
     *
     * @return array カスタムバリデーションエラーメッセージの配列
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
