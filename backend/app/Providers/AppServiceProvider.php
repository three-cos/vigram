<?php

namespace App\Providers;

use App\Contracts\CurrencyUpdater;
use App\Services\Currency\DummyUpdater;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        $this->app->bind(CurrencyUpdater::class, DummyUpdater::class);
    }
}
