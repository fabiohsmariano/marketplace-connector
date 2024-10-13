<?php

namespace App\Listeners;

use App\Events\AdsFetchedFromMarketplace;
use App\Jobs\SendAdsToHub;

class HandleAdsFetched
{
    /**
     * Handle the event.
     */
    public function handle(AdsFetchedFromMarketplace $event)
    {
        SendAdsToHub::dispatch($event->adverts, $event->import);
    }
}
