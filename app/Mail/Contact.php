<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Contact extends Mailable
{
    use Queueable, SerializesModels;

    public object $msg;

    /**
     * Crea una nueva instancia del mensaje.
     */
    public function __construct(array $msg)
    {
        // Lo casteamos a objeto para que tu Blade siga usando $msg->name
        $this->msg = (object) $msg;
    }

    /**
     * Configura el encabezado del correo.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Message received by '.config('app.name'),
            // Para poder darle "Responder" directamente al cliente en tu bandeja:
            replyTo: [
                new Address($this->msg->email, $this->msg->name),
            ],
        );
    }

    /**
     * Construye el cuerpo del mensaje apuntando a tu vista Markdown.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.contact',
        );
    }
}
