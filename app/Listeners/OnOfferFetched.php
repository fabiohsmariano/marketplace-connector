<?php

namespace App\Listeners;

use App\Events\OfferFetched;
use App\Jobs\SendOffer;

class OnOfferFetched
{
    /**
     * Handle the event.
     */
    public function handle(OfferFetched $event)
    {
        $import = $event->getImport();
        $offer = $event->getOffer();

        SendOffer::dispatch($import, $offer);
    }
}
