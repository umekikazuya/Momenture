<?php

namespace App\Http\Requests\Article;

use App\Models\Article;
use Illuminate\Foundation\Http\FormRequest;

class ShowRequest extends FormRequest
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
            'title' => 'required|string',
            'link' => 'required|string',
            'published' => 'required|string',
            'is_pickup' => 'required|boolean',
        ];
    }

    public function makeArticle(): Article
    {
        // バリデーションした値で埋めた Article を取得
        return new Article($this->validated());
    }
}
