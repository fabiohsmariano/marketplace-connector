<?php

namespace App\Jobs;

use App\Enums\ImportStatus;
use App\Events\AdsSentToHub;
use App\Models\Import;
use App\Repositories\MockRepository;
use App\Services\ImportService;
use Exception;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendAdsToHub implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected $adverts,
        protected Import $import
    ) {
    }

    /**
     * Sends the ads to the Hub.
     *
     * This function sends all the ads to the Hub, and then fires an AdsSentToHub event.
     * If any error happens during the process, it logs the error and sets the import status to "failed".
     *
     * @return void
     */
    public function handle()
    {
        $importService = new ImportService();
        $mockRepository = new MockRepository();

        try {
            Log::info('SendAdsToHub job started!', ['import_data' => print_r($this->import->toArray(), true)]);

            foreach ($this->adverts as $advert) {
                $mockRepository->sendAd($advert);
            }

            Log::info('Ads sent to HUB successfully! Starting AdsSentToHub event.', ['import_id' => $this->import->id]);

            event(new AdsSentToHub($this->import));
        } catch (Exception $e) {
            Log::alert('Error while sendind ads to HUB', [
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
