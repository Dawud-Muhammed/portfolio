<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreContactRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:2', 'max:120'],
            'email' => ['required', 'email:rfc,dns', 'max:160'],
            'subject' => ['nullable', 'string', 'max:160'],
            'message' => ['required', 'string', 'min:12', 'max:3000'],
            'website' => [Rule::prohibitedIf(fn () => filled($this->input('website')))],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please provide a valid email address.',
            'message.required' => 'Please write a message.',
            'message.min' => 'Your message should be at least 12 characters.',
        ];
    }
}
