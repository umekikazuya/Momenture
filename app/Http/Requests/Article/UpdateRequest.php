<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'nullable|string|max:255',
            'link' => 'nullable|url',
            'service' => 'nullable|integer|exists:article_services,id',

        ];
    }

    public function messages(): array
    {
        return [
            'title.max' => 'タイトルは255文字以内で入力してください。',
            'service.exists' => '選択されたサービスは無効です。',
            'link.url' => 'リンクは有効なURLを入力してください。',
        ];
    }
}
