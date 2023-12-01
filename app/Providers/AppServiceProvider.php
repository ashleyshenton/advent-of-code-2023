<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Http::macro('aocDay', function (int $date) {
            throw_unless($cookie = env('SESSION_COOKIE'), 'No session cookie has been specified.');

            return Http::withCookies(['session' => $cookie], '.adventofcode.com')
                ->get("https://adventofcode.com/2023/day/$date/input")
                ->body();
        });
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}
