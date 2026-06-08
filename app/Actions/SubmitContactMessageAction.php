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
        // 1. Preparamos la data
        $data['phone'] = ! empty($data['phone']) ? $data['phone'] : 'No proporcionado';

        // 2. Guardamos en la base de datos (Garantiza que no se pierda la información)
        $emailRecord = Email::create($data);

        // 3. Envío óptimo usando BCC con captura de errores
        try {
            Mail::to($data['email'], $data['name'])
                ->bcc('hi@clicksalinas.com', config('app.name'))
                ->send(new Contact($data));

        } catch (Throwable $e) {
            // Si el SMTP falla, registramos el error sin reventar la vista del usuario
            Log::error('Fallo al enviar el correo de contacto: '.$e->getMessage(), [
                'email_record_id' => $emailRecord->id,
                'client_email' => $data['email'],
            ]);
        }

        return $emailRecord;
    }
}
