<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminProjectRequest extends FormRequest
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
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:projects,slug'],
            'description' => ['required', 'string', 'max:1200'],
            'details' => ['required', 'string'],
            'stack' => ['required', 'string', 'max:500'],
            'image' => ['nullable', 'url', 'max:2048', 'required_without:image_file'],
            'image_file' => ['nullable', 'image', 'max:4096', 'dimensions:max_width=3000,max_height=3000', 'required_without:image'],
            'github_url' => ['nullable', 'url', 'max:2048'],
            'demo_url' => ['nullable', 'url', 'max:2048'],
            'is_featured' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ];
    }
}
