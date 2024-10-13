<?php

namespace App\Listeners;

use App\Events\ImportRequested;
use App\Jobs\FetchAdsFromMarketplace;

class HandleImportRequest
{
    /**
     * Handle the event.
     */
    public function handle(ImportRequested $event)
    {
        FetchAdsFromMarketplace::dispatch($event->importData);
    }
}
