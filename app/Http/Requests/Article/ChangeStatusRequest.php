<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class ChangeStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'new_status' => 'required|in:draft,published',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
