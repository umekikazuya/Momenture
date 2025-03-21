<?php

declare(strict_types=1);

namespace App\Http\Requests\FeaturedArticle;

use Illuminate\Foundation\Http\FormRequest;

class ChangePriorityRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'priority' => 'required|integer|min:1',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
