<?php

use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\BoldWebhookController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\PortfolioController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Paginas
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'index'])->name('pages.home');
Route::get('/about', [PageController::class, 'about'])->name('pages.about');

/*
|--------------------------------------------------------------------------
| Contacto
|--------------------------------------------------------------------------
*/
Route::get('/contact', [ContactController::class, 'index'])->name('pages.contact');
Route::post('/mail', [ContactController::class, 'store'])->name('mail.sent');

/*
|--------------------------------------------------------------------------
| Paginas Estáticas
|--------------------------------------------------------------------------
*/

Route::view('/privacy-policy', 'privacy-policy')->name('privacy.policy');
Route::view('/terms', 'terms')->name('terms');
/*
|--------------------------------------------------------------------------
| Sitemap
|--------------------------------------------------------------------------
*/
Route::get('/sitemap.xml', [SitemapController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Portafolio
|--------------------------------------------------------------------------
*/
// Lista de un servicio específico (Ej: /photographs/weddings)
Route::get('photographs/{service:slug}', [PortfolioController::class, 'service'])->name('portfolio.service');

// Un álbum o sesión fotográfica (Ej: /photography/laura-julian)
Route::get('photography/{album:slug}', [PortfolioController::class, 'album'])->name('portfolio.album');

/*
|--------------------------------------------------------------------------
| Checkout / Pagos
|--------------------------------------------------------------------------
*/
Route::get('checkout/result', [CheckoutController::class, 'result'])->name('checkout.result');
Route::get('checkout/{reservation:uuid}', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('checkout/{reservation:uuid}/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::post('webhooks/bold', [BoldWebhookController::class, 'handle'])->name('webhooks.bold');
/*
|--------------------------------------------------------------------------
| Blog
|--------------------------------------------------------------------------
*/
Route::get('blog', [BlogController::class, 'index'])->name('blog.index');

// Post individual (Ej: /blog/best-places-for-photos-in-cartagena)
Route::get('blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');

// Categorías
Route::get('categories/{category:slug}', [BlogController::class, 'category'])->name('blog.category');

/*
|--------------------------------------------------------------------------
| Redirecciones SEO Históricas
|--------------------------------------------------------------------------
*/
Route::redirect('/tags/the-best-photographer-cartagena', '/tags/the-best-photographer-in-cartagena', 301);
Route::redirect('/tags/the-best-photographers-in-cartagena', '/tags/the-best-photographer-in-cartagena', 301);
Route::redirect('/tags/cartagena-photographer', '/tags/photographer-in-cartagena', 301);
Route::redirect('/tags/cartagena', '/tags/cartagena-de-indias', 301);

// Tags
Route::get('tags/{tag:slug}', [BlogController::class, 'tag'])->name('blog.tag');
