<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;

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
        //URL::forceScheme('https');

        // Schema::defaultStringLength(191);
        // Blade::aliasComponent('admin.components.message', 'message');

        // $configuracoes = \App\Models\Config::find(1); 
        // View()->share('configuracoes', $configuracoes);

        // Paginator::useBootstrap();
    }
}
