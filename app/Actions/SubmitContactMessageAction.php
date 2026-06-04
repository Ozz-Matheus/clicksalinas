<?php

declare(strict_types=1);

namespace App\Actions;

use App\Mail\Contact;
use App\Models\Email;
use Illuminate\Support\Facades\Mail;

class SubmitContactMessageAction
{
    /**
     * Ejecuta el guardado del mensaje y el envío del correo.
     */
    public function execute(array $data): Email
    {
        // 1. Preparamos la data
        $data['phone'] = ! empty($data['phone']) ? $data['phone'] : 'No proporcionado';

        // 2. Guardamos en la base de datos
        $emailRecord = Email::create($data);

        // 3. Envío óptimo usando BCC
        Mail::to($data['email'], $data['name'])
            ->bcc('hi@clicksalinas.com', config('app.name'))
            ->send(new Contact($data));

        return $emailRecord;
    }
}
