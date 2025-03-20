<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * 全てのリクエストを認可するため、常にtrueを返します。
     *
     * このメソッドは、認可チェックをスキップし、リクエストを常に許可する実装になっています。
     *
     * @return bool 常にtrueを返します。
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * 記事保存リクエスト用の検証ルールを返します。
     *
     * このメソッドは、記事保存フォームで送信されたデータに対するバリデーションルールを定義します。
     * 具体的なルールは以下の通りです:
     * - 'title': 必須、文字列、最大255文字
     * - 'status': 必須、値は 'draft' または 'published' のみ許可
     * - 'service': 必須、整数、article_servicesテーブルに存在するIDであること
     * - 'link': 任意、URL形式
     *
     * @return array 検証ルールの連想配列
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'status' => 'required|in:draft,published',
            'service' => 'required|integer|exists:article_services,id',
            'link' => 'nullable|url',
        ];
    }

    /**
     * フォームリクエストのカスタムバリデーションエラーメッセージを返却する。
     *
     * このメソッドは、各バリデーションルールに対応するエラーメッセージを連想配列形式で提供します。
     *
     * @return array バリデーションルールをキー、対応するエラーメッセージを値とする連想配列
     */
    public function messages(): array
    {
        return [
            'title.required' => 'タイトルは必須です。',
            'title.max' => 'タイトルは255文字以内で入力してください。',
            'status.required' => 'ステータスは必須です。',
            'status.in' => 'ステータスは`draft`または`published`のいずれかを選択してください。',
            'service.required' => 'サービスは必須です。',
            'service.exists' => '選択されたサービスは無効です。',
            'link.url' => 'リンクは有効なURLを入力してください。',
        ];
    }
}
