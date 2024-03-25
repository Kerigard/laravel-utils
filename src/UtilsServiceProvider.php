<?php

namespace Kerigard\LaravelUtils;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Kerigard\LaravelUtils\Routing\RemovableRoutesMixin;

class UtilsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::mixin(new RemovableRoutesMixin());
    }
}
