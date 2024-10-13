<?php

namespace App\Events;

use App\Models\Import;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ImportRequested
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Import $importData
    ) {
    }
}
