<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\Contact;
use App\Models\Email;
use App\Models\StaticPage;
use App\Rules\Recaptcha;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Muestra la vista del formulario de contacto
     */
    public function index(): View
    {
        $page = StaticPage::where('slug', 'contact')->firstOrFail();

        return view('pages', [
            'page' => $page,
            'cover' => $page->cover_image_path ? $page->cover_image_path : null,
        ]);
    }

    /**
     * Procesa el formulario y envía el correo
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'regex:/^\+[1-9]\d{1,3}[ \d]{6,14}$/'],
            'message' => ['required', 'string'],
            'g-recaptcha-response' => ['required', new Recaptcha],
        ], [
            'g-recaptcha-response.required' => 'Por favor, verifica que no eres un robot marcando la casilla.',
            'phone.regex' => 'Please include your country code starting with "+" (e.g. +52 or +57).',
        ]);

        $dataToSave = $validated;
        $dataToSave['phone'] = $request->filled('phone') ? $validated['phone'] : 'No proporcionado';

        // 1. Guardar en la base de datos
        Email::create($dataToSave);

        // 2. Envío óptimo en 1 sola transacción SMTP usando Copia Oculta (BCC)
        Mail::to($validated['email'], $validated['name'])
            ->bcc('hi@clicksalinas.com', config('app.name'))
            ->send(new Contact($dataToSave));

        return back()->with('flash', 'Thank you! Your message has been sent successfully.');
    }
}
