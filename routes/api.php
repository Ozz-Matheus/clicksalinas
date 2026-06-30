<?php

use App\Http\Controllers\Api\N8nCheckoutController;
use App\Http\Controllers\Api\N8nPostController;
use App\Http\Middleware\VerifyN8nToken;
use Illuminate\Support\Facades\Route;

Route::middleware([VerifyN8nToken::class])->group(function () {
    Route::post('/n8n/posts', [N8nPostController::class, 'store']);
    Route::post('/n8n/reservations/void', [N8nCheckoutController::class, 'voidReservation']);
    Route::post('/generate-checkout', [N8nCheckoutController::class, 'store']);
});
