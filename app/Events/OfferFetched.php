<?php

namespace App\Events;

use App\Entities\Import;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OfferFetched
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Import $import,
        public array $offer
    ) {
    }

    public function getImport(): Import
    {
        return $this->import;
    }

    public function getOffer(): array
    {
        return $this->offer;
    }
}
