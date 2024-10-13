<?php

namespace App\Events;

use App\Models\Import;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdsSentToHub
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Import $import
    ) {
    }
}
