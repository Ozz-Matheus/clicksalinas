<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreN8nPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // La autorización ya la maneja el middleware
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string'],
            'body' => ['required', 'string'],
            'category_slug' => ['required', 'string', 'exists:categories,slug'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['string'],
            'published_at' => ['nullable', 'date'],
            'user_id' => ['nullable', 'exists:users,id'], // Opcional: para asignar el autor
        ];
    }
}
