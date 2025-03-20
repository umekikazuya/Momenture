<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * リクエストが許可されているかを判定する。
     *
     * このメソッドは常に true を返すため、すべてのユーザーがリクエストを実行できることを示します。
     *
     * @return bool 常に true。
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * リクエストデータのバリデーションルールを返します。
     *
     * このメソッドは、記事作成・更新リクエストに対する各フィールドのバリデーションルールを定義した連想配列を返します。
     * ルールには必須のタイトル（文字列、最大255文字）、必須のステータス（"draft"または"published"のいずれか）、
     * 必須のサービスID（整数、存在確認付き）、および任意のリンク（有効なURL）が含まれます。
     *
     * @return array バリデーションルールの連想配列
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
     * バリデーションエラーのカスタムメッセージを返します。
     *
     * 各バリデーションルールに対して適用されるエラーメッセージを定義した連想配列を返します。
     *
     * @return array 各ルールに対応するエラーメッセージの連想配列
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
