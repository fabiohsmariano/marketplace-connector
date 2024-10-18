<?php

namespace App\Listeners;

use App\Events\ImportCreated;
use App\Jobs\FetchOfferReferences;

class OnImportCreated
{
    /**
     * Handle the event.
     */
    public function handle(ImportCreated $event)
    {
        $import = $event->getImport();

        FetchOfferReferences::dispatch($import, 1);
    }
}
