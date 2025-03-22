<?php

namespace App\Http\Requests\ArticleService;

use Illuminate\Foundation\Http\FormRequest;

class ShowRequest extends FormRequest
{
    /**
     * ユーザーがこのリクエストを実行する権限があるかを判定する。
     *
     * 本メソッドは常に true を返すため、すべてのユーザーがリクエストを実行できます。
     *
     * @return bool 常に true
     */
    public function authorize(): bool
    {
        return true;
    }
}
