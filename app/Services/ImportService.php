<?php

namespace App\Services;

use App\Enums\ImportStatus;
use App\Events\ImportRequested;
use App\Models\Import;
use Illuminate\Support\Facades\Log;

class ImportService
{
    /**
     * Start a new import.
     *
     * This will create a new Import model, and dispatch a job to import
     * all ads from the marketplace.
     *
     * @return void
     */
    public function handle(): void
    {
        $import = $this->createImport();

        Log::info('Import created on database.', ['import_id' => $import->id]);

        $this->createImportRequestedEvent($import);
    }

    /**
     * Create a new Import model.
     *
     * @return Import
     */
    private function createImport(): Import
    {
        return Import::create();
    }

    /**
     * Dispatch a job to import all ads from the marketplace.
     *
     * @param Import $import
     * @return void
     */
    private function createImportRequestedEvent(Import $import): void
    {
        Log::info('ImportRequested event starting.', ['import_data' => print_r($import->toArray(), true)]);

        event(new ImportRequested($import));
    }

    /**
     * Update the status of an import.
     *
     * @param Import $import
     * @return void
     */
    public function updateImportStatus(Import $import, $status): void
    {
        $import->update([
            'status' => $status
        ]);
    }
}
