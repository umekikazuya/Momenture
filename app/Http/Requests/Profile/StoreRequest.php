<?php

namespace App\Http\Requests\Profile;

use App\Models\Profile;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'address' => 'nullable|string|max:255',
            'display_name' => 'nullable|string|max:255',
            'display_short_name' => 'nullable|string|max:255',
            'from' => 'nullable|string|max:255',
            'github' => 'nullable|string|max:255',
            'introduction' => 'nullable|string|max:1000',
            'job' => 'nullable|string|max:255',
            'likes.*' => 'nullable|string|max:255',
            'likes' => 'nullable|array',
            'qiita' => 'nullable|string|max:255',
            'skill.*' => 'string|max:255',
            'skill' => 'nullable|array',
            'summary_introduction' => 'nullable|string|max:1000',
            'zenn' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'skill.array' => 'Skillは配列形式で送信してください。',
            'likes.array' => 'Likesは配列形式で送信してください。',
        ];
    }

    public function makeProfile(): Profile
    {
        return new Profile($this->validated());
    }
}
