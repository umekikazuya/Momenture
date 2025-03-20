<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'status' => 'required|in:draft,published',
            'service' => 'required|integer|exists:services,id',
            'link' => 'nullable|url',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
