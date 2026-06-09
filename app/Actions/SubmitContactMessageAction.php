<?php

declare(strict_types=1);

namespace App\Actions;

use App\Mail\Contact;
use App\Models\Email;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SubmitContactMessageAction
{
    /**
     * Ejecuta el guardado del mensaje y el envío del correo de forma segura.
     */
    public function execute(array $data): Email
    {
        // Normalizamos el teléfono
        $phone = $data['phone'] ?? null;

        $data['phone'] = filled($phone)
            ? $phone
            : 'No proporcionado';

        // Guardamos el mensaje en base de datos
        $emailRecord = Email::create($data);

        // Intentamos enviar el correo sin romper la experiencia del usuario
        try {
            Mail::to($data['email'], $data['name'])
                ->bcc('hi@clicksalinas.com', config('app.name'))
                ->send(new Contact($data));

        } catch (Throwable $e) {
            Log::error(
                'Fallo al enviar el correo de contacto',
                [
                    'exception' => $e,
                    'email_record_id' => $emailRecord->id,
                    'client_email' => $data['email'],
                ]
            );
        }

        return $emailRecord;
    }
}
