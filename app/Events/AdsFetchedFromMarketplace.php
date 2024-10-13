<?php

namespace App\Events;

use App\Models\Import;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdsFetchedFromMarketplace
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public $adverts,
        public Import $import
    ) {
    }
}
