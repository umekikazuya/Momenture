<?php

declare(strict_types=1);

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    /**
     * 記事検索リクエストの検証ルールの配列を返します。
     *
     * このメソッドは、記事検索に使用される各パラメータの検証ルールを定義しています。
     * - status: null許容。'draft'または'published'のみ有効。
     * - service_id: null許容。整数値で、article_servicesテーブルに存在する必要があります。
     * - tag_id: null許容。整数値で、tagsテーブルに存在する必要があります。
     * - sort: null許容。文字列である必要があります。
     * - page: null許容。整数値で1以上である必要があります。
     * - per_page: null許容。整数値で1から100の範囲である必要があります。
     *
     * @return array 検証ルールの配列
     */
    public function rules(): array
    {
        return [
            'status' => 'nullable|in:draft,published',
            'service_id' => 'nullable|integer|exists:article_services,id',
            'tag_id' => 'nullable|integer|exists:tags,id',
            'sort' => 'nullable|string',
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:100',
        ];
    }

    /**
     * すべてのユーザーにリクエストの実行を許可します。
     *
     * このメソッドは常にtrueを返すため、ユーザーの認証チェックが不要な場合に利用されます。
     *
     * @return bool 常にtrue
     */
    public function authorize(): bool
    {
        return true;
    }
}
