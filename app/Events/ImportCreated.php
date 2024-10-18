<?php

namespace App\Events;

use App\Entities\Import;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ImportCreated
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Import $import
    ) {
    }

    public function getImport(): Import
    {
        return $this->import;
    }
}
