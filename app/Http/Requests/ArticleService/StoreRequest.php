<?php

namespace App\Http\Requests\ArticleService;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'サービス名は必須です。',
            'name.max' => 'サービス名は255文字以内で入力してください。',
        ];
    }
}
