<?php

namespace App\Jobs;

use App\Enums\ImportStatus;
use App\Models\Import;
use App\Services\ImportService;
use Exception;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class FinishImport implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected Import $import
    ) {
    }

    /**
     * Finish the import.
     *
     * This job will update the status of the import to 'completed', unless an exception occurs.
     * If an exception occurs, it will log the exception and update the status to 'failed'.
     *
     * @return void
     */
    public function handle()
    {
        $importService = new ImportService();

        try {
            $importService->updateImportStatus($this->import, ImportStatus::COMPLETED->value);

            Log::info('Import status updated to "completed". Import finished!', ['import_id' => $this->import->id]);
        } catch (Exception $e) {
            Log::alert('Error while finishing import', [
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'import_id' => $this->import->id,
                'import_data' => print_r($this->import->toArray(), true)
            ]);

            $importService->updateImportStatus($this->import, ImportStatus::FAILED->value);
        }

    }
}
