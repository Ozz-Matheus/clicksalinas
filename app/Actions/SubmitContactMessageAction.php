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
     *
     * @param array{
     * name: string,
     * email: string,
     * phone?: string|null,
     * message: string,
     * 'g-recaptcha-response'?: string
     * } $data
     */
    public function execute(array $data): Email
    {
        // Guardamos el mensaje en base de datos
        $emailRecord = Email::create($data);

        // Intentamos enviar el correo sin romper la experiencia del usuario
        try {
            // Obtenemos el correo desde la configuración (por defecto fallback al de admin)
            $adminEmail = config('mail.admin_address', 'hi@clicksalinas.com');

            Mail::to($data['email'], $data['name'])
                ->bcc($adminEmail, config('app.name'))
                ->send(new Contact($data));
        } catch (Throwable $e) {
            Log::error('Fallo al enviar el correo de contacto', [
                'email_record_id' => $emailRecord->id,
                'client_email' => $data['email'],
                'exception' => $e->getMessage(),
            ]);
        }

        return $emailRecord;
    }
}
