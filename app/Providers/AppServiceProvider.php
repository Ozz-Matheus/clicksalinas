<?php

namespace App\Providers;

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
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFour();
        Paginator::defaultView('vendor.pagination.default');

        Column::configureUsing(function (Column $column) {
            $column->toggleable();
        });

    }
}
