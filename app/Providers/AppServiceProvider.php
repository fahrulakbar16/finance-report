<?php

namespace App\Providers;

use App\Models\Villa;
use Illuminate\Support\Facades\View;
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
        \Illuminate\Pagination\Paginator::useBootstrapFive();

        View::composer(['welcome', 'layouts.landing'], function ($view) {
            $view->with('footerVillas', Villa::latest()->take(6)->get(['id', 'name']));
        });

        View::composer('welcome', function ($view) {
            $view->with('homeVillas', Villa::with('rooms')->latest()->take(3)->get());
        });
    }
}
