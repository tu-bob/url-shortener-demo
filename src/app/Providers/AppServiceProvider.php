<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Services\UrlShortener::class,
            \App\Domain\Services\RandomUrlShortener::class
        );

        $this->app->bind(
            \App\Domain\Repositories\UrlRepository::class,
            \App\Infrastructure\DB\Repositories\UrlRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
