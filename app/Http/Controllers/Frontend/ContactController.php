<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Actions\SubmitContactMessageAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\StaticPage;
use Illuminate\Http\RedirectResponse;
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

    public function store(ContactRequest $request, SubmitContactMessageAction $submitContactMessage): RedirectResponse
    {
        $submitContactMessage->execute($request->validated());

        return back()->with('flash', 'Thank you! Your message has been sent successfully.');
    }
}
