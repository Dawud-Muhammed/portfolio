<?php

namespace App\Http\Requests\Admin;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAdminPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, \Illuminate\Validation\Rules\Unique|string>>
     */
    public function rules(): array
    {
        /** @var Post $post */
        $post = $this->route('post');

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', Rule::unique('posts', 'slug')->ignore($post->id)],
            'excerpt' => ['required', 'string', 'max:600'],
            'body' => ['required', 'string'],
            'cover_image' => ['required', 'url', 'max:2048'],
            'published_at' => ['nullable', 'date'],
            'reading_time_minutes' => ['required', 'integer', 'min:1', 'max:120'],
        ];
    }
}
