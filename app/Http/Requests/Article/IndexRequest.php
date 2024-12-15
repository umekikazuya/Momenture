<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'is_pickup' => 'nullable|boolean',
        ];
    }

    public function filters(): array
    {
        return $this->only(['title', 'is_pickup']);
    }

    public function sort(): array
    {
        return $this->input('sort', ['created_at' => 'desc']);
    }

    public function pagination(): array
    {
        return [
            'per_page' => $this->input('per_page', 15),
            'page' => $this->input('page', 1),
        ];
    }
}
