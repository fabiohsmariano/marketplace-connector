<?php

namespace App\Providers;

use App\Events\AdsFetchedFromMarketplace;
use App\Events\AdsSentToHub;
use App\Events\ImportRequested;
use App\Listeners\HandleAdsFetched;
use App\Listeners\HandleAdsSent;
use App\Listeners\HandleImportRequest;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Event::listen(
            ImportRequested::class,
            HandleImportRequest::class,

            AdsFetchedFromMarketplace::class,
            HandleAdsFetched::class,

            AdsSentToHub::class,
            HandleAdsSent::class
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
