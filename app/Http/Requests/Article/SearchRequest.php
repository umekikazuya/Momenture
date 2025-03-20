<?php

declare(strict_types=1);

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    /**
     * 記事検索リクエスト用のバリデーションルールを返します。
     *
     * このメソッドは、記事の検索リクエストに対して適用されるバリデーションルールの一覧を定義しています。
     * ルールは以下のパラメータに対応しており、各項目は任意入力です:
     * - status: 'draft' または 'published' のどちらかの文字列。
     * - service_id: 整数で、article_servicesテーブルに存在する必要があります。
     * - tag_id: 整数で、tagsテーブルに存在する必要があります。
     * - sort: 文字列。
     * - page: 1以上の整数。
     * - per_page: 1以上100以下の整数。
     *
     * @return array バリデーションルールの配列
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
     * すべてのユーザにリクエスト実行の権限を許可するため、常にtrueを返します。
     *
     * このメソッドは、認可チェックのデフォルト実装として、全ユーザがリクエストを実行できることを示します。
     *
     * @return bool 常にtrue
     */
    public function authorize(): bool
    {
        return true;
    }
}
