<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcessCheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Permitimos el paso porque el middleware VerifyN8nToken ya protege la ruta
    }

    public function rules(): array
    {
        return [
            'crm_task_id' => ['required', 'string'],
            'service_id' => ['nullable', 'exists:services,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'amount' => ['required', 'integer', 'min:50000'],
        ];
    }
}
