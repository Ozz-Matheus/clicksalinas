<?php

use App\Models\Email;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

beforeEach(function () {
    Http::fake(['www.google.com/recaptcha/api/siteverify' => Http::response(['success' => true])]);
    Mail::fake();
});

function validContactData(): array
{
    return [
        'name' => 'Example Client',
        'email' => 'client@example.com',
        'phone' => '+14055550123',
        'message' => 'I would like to book a photoshoot.',
        'g-recaptcha-response' => 'test-recaptcha-token',
    ];
}

test('contact submissions store their source metadata', function () {
    $this->withServerVariables([
        'REMOTE_ADDR' => '203.0.113.25',
        'HTTP_USER_AGENT' => 'ContactTestBrowser',
    ])->post('/mail', validContactData())->assertRedirect();

    expect(Email::count())->toBe(1);
    expect(Email::first()->ip_address)->toBe('203.0.113.25');
    expect(Email::first()->user_agent)->toBe('ContactTestBrowser');
});

test('honeypot filled submissions are rejected', function () {
    $this->post('/mail', array_merge(validContactData(), ['website' => 'https://spam.example']))
        ->assertSessionHasErrors('website');

    expect(Email::count())->toBe(0);
});

test('contact submissions are rate limited', function () {
    for ($attempt = 0; $attempt < 5; $attempt++) {
        $this->post('/mail', validContactData())->assertRedirect();
    }

    $this->post('/mail', validContactData())->assertStatus(429);
    expect(Email::count())->toBe(5);
});
