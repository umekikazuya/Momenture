<?php

declare(strict_types=1);

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    /**
     * 入力リクエストのバリデーションルールを返します。
     *
     * このメソッドは、記事検索リクエストの入力パラメータに対して以下の検証ルールを定義します:
     * - status: 指定された場合、「draft」または「published」のいずれかである必要があります。
     * - service_id: 指定された場合、整数であり、article_servicesテーブルに該当するIDでなければなりません。
     * - tag_id: 指定された場合、整数であり、tagsテーブルに該当するIDでなければなりません。
     * - sort: 指定された場合、文字列でなければなりません。
     * - page: 指定された場合、整数であり、1以上である必要があります。
     * - per_page: 指定された場合、整数であり、1から100の範囲でなければなりません。
     *
     * @return array バリデーションルールの連想配列
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
     * リクエストの許可判定を行います。
     *
     * このメソッドは常に true を返し、全てのユーザーがリクエストを実行できることを示します。
     *
     * @return bool 常に true を返します。
     */
    public function authorize(): bool
    {
        return true;
    }
}
