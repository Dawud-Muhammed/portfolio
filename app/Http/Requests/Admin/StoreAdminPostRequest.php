<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:posts,slug'],
            'excerpt' => ['required', 'string', 'max:600'],
            'body' => ['required', 'string'],
            'cover_image' => ['required', 'url', 'max:2048'],
            'published_at' => ['nullable', 'date'],
            'reading_time_minutes' => ['required', 'integer', 'min:1', 'max:120'],
        ];
    }
}
