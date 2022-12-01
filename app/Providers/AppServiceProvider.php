<?php

namespace App\Providers;

use App\Contracts\Services\CsvInterface;
use Illuminate\Support\ServiceProvider;
use App\Contracts\Services\InventoryInterface;
use App\Services\CsvService;
use App\Services\InventoryService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(InventoryInterface::class, InventoryService::class);
        $this->app->bind(CsvInterface::class, CsvService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
