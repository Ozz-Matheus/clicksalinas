<?php

namespace App\Providers;

use App\Models\Reservation;
use App\Observers\ReservationObserver;
use App\Services\BoldPaymentService;
use Filament\Tables\Columns\Column;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BoldPaymentService::class, function ($app) {
            return new BoldPaymentService(
                config('services.bold.api_key'),
                config('services.bold.endpoint')
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Reservation::observe(ReservationObserver::class);

        Paginator::useBootstrapFour();
        Paginator::defaultView('vendor.pagination.default');

        Column::configureUsing(function (Column $column) {
            $column->toggleable();
        });

    }
}
