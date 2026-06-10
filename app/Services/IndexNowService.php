<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class IndexNowService
{
    public function submit(string $url): void
    {
        // 1. Evitar hacer pings a los buscadores si estamos en desarrollo local
        if (app()->environment('local')) {
            return;
        }

        $key = config('seo.indexnow_key');

        // Si por alguna razón la llave no está configurada, abortamos silenciosamente
        if (empty($key)) {
            Log::warning('IndexNow API Key no está configurada en el .env');

            return;
        }

        try {
            $host = parse_url(config('app.url'), PHP_URL_HOST);

            Http::timeout(3)->post('https://api.indexnow.org/indexnow', [
                'host' => $host,
                'key' => $key,
                'keyLocation' => config('app.url').'/'.$key.'.txt',
                'urlList' => [$url],
            ]);

        } catch (Throwable $e) {
            Log::error('IndexNow Error: '.$e->getMessage());
        }
    }
}
