<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Actions\SubmitContactMessageAction;
use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use App\Rules\Recaptcha;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        $page = StaticPage::where('slug', 'contact')->firstOrFail();

        return view('pages', [
            'page' => $page,
            'cover' => $page->cover_image_path ? $page->cover_image_path : null,
        ]);
    }

    // Inyectamos el Action directamente en el método
    public function store(Request $request, SubmitContactMessageAction $submitContactMessage): RedirectResponse
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

        // Delegamos la lógica de negocio pesada al Action
        $submitContactMessage->execute($validated);

        return back()->with('flash', 'Thank you! Your message has been sent successfully.');
    }
}
