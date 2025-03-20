<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * リクエストが承認されているかを判定する。
     *
     * 常に true を返すため、全てのユーザーによるリクエストを許可します。
     *
     * @return bool 全てのリクエストを許可するため true を返します。
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * リクエストのバリデーションルールを返します。
     *
     * 記事を保存する際に使用される各フィールドの検証ルールを定義しています:
     * - title: 必須、文字列、最大255文字
     * - status: 必須、"draft" または "published" のみ許容
     * - service: 必須、整数、article_servicesテーブルに存在するidであること
     * - link: 任意、URL形式（値が存在する場合）
     *
     * @return array バリデーションルールを格納した連想配列
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
     * バリデーションエラーメッセージを返します。
     *
     * 各フィールドに対応するカスタムバリデーションエラーのメッセージを定義した連想配列を返します。
     *
     * @return array カスタムエラーメッセージの連想配列
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
