<?php

namespace App\Http\Requests;

use App\Rules\Recaptcha;
use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^\+[1-9]\d{1,3}[ \d]{6,14}$/'],
            'message' => ['required', 'string'],
            'g-recaptcha-response' => ['required', new Recaptcha],
        ];
    }

    public function messages(): array
    {
        return [
            'g-recaptcha-response.required' => 'Please verify that you are not a robot by checking the box.',
            'phone.regex' => 'Please include your country code starting with "+" (e.g. +52 or +57).',
        ];
    }
}
