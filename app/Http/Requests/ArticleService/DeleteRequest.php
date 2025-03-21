<?php

namespace App\Http\Requests\ArticleService;

use Illuminate\Foundation\Http\FormRequest;

class DeleteRequest extends FormRequest
{
    /**
     * ユーザーがこのリクエストを実行する権限を持っているかを判定します。
     *
     * 常に true を返すため、どのユーザーでもリクエストの実行が許可されます。
     *
     * @return bool 常に true
     */
    public function authorize(): bool
    {
        return true;
    }
}
