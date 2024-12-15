<?php

namespace App\Http\Requests\Article;

use App\Models\Article;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'title' => 'nullable|string',
            'link' => 'nullable|string',
            'published' => 'nullable|string',
            'is_pickup' => 'nullable|boolean',
        ];
    }

    /**
     * Retrieve the Article instance based on the ID in the route.
     */
    public function findArticle(string $id): Article
    {
        return Article::findOrFail($id);
    }

    /**
     * Apply validated data to the Article instance.
     */
    public function fillArticle(Article &$article): void
    {
        $article->fill($this->validated());
    }
}
