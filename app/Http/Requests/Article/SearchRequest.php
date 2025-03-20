<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => 'nullable|in:draft,published',
            'service_id' => 'nullable|integer|exists:services,id',
            'tag_id' => 'nullable|integer|exists:tags,id',
            'sort' => 'nullable|string',
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:100',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
