<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'nullable|string|max:255',
            'link' => 'nullable|url',
            'service' => 'nullable|integer|exists:article_services,id',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
