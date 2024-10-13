<?php

namespace App\Listeners;

use App\Events\AdsSentToHub;
use App\Jobs\FinishImport;

class HandleAdsSent
{
    /**
     * Handle the event.
     */
    public function handle(AdsSentToHub $event)
    {
        FinishImport::dispatch($event->import);
    }
}
