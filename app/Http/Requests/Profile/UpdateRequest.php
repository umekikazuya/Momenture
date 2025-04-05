<?php

namespace App\Http\Requests\Profile;

use App\Application\DTOs\ProfileDto;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * {@inheritDoc}
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'address' => 'nullable|string|max:255',
            'display_name' => 'nullable|string|max:255',
            'display_short_name' => 'nullable|string|max:100',
            'from' => 'nullable|string|max:255',
            'github' => 'nullable|string',
            'introduction' => 'nullable|string',
            'job' => 'nullable|string|max:100',
            'likes' => 'nullable|array',
            'likes.*' => 'string|max:50',
            'qiita' => 'nullable|string',
            'skills' => 'nullable|array',
            'skills.*' => 'string|max:50',
            'summary_introduction' => 'nullable|string|max:500',
            'zenn' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'skill.array' => 'Skillは配列形式で送信してください。',
            'likes.array' => 'Likesは配列形式で送信してください。',
        ];
    }

    public function toDto(): ProfileDto
    {
        return ProfileDto::fromArray([
            ...$this->validated(),
            'id' => 1,
        ]);
    }
}
