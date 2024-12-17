<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * {@inheritDoc}
     *
     * @return boolean
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'github' => 'nullable|string|max:255',
            'qiita' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'zenn' => 'nullable|string|max:255',
            'skill' => 'nullable|array',
            'skill.*' => 'string|max:255',
            'display_name' => 'nullable|string|max:255',
            'display_short_name' => 'nullable|string|max:255',
            'from' => 'nullable|string|max:255',
            'likes' => 'nullable|array',
            'likes.*' => 'string|max:255',
            'summary_introduction' => 'nullable|string|max:1000',
            'introduction' => 'nullable|string|max:1000',
            'job' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'skill.array' => 'Skillは配列形式で送信してください。',
            'likes.array' => 'Likesは配列形式で送信してください。',
        ];
    }
}
