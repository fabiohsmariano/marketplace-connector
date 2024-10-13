<?php

namespace App\Jobs;

use App\Enums\ImportStatus;
use App\Events\AdsFetchedFromMarketplace;
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

class FetchAdsFromMarketplace implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected Import $import
    ) {
    }

    /**
     * Fetches all ads from the mock marketplace.
     *
     * This will fetch all ad references from the marketplace, and then fetch
     * the ad data, images and price for each reference. It will update the
     * status of the import to 'processing' while the job is running, and
     * then back to 'completed' once the job is finished.
     *
     * @return void
     */
    public function handle()
    {
        $importService = new ImportService();
        $mockRepository = new MockRepository();

        try {
            $importService->updateImportStatus($this->import, ImportStatus::IN_PROGRESS->value);

            Log::info('FetchAdsFromMarketplace job started!', ['import_data' => print_r($this->import->toArray(), true)]);

            $page = 1;

            $adverts = [];

            do {
                $references = $mockRepository->fetchReferences($page);

                if ($references !== []) {
                    Log::info("Offer references of page $page fetched successfully.", ['references' => print_r($references, true)]);

                    foreach ($references as $reference) {
                        $advert = $mockRepository->fetchAdByReference($reference);
                        $advert['images'] = $mockRepository->fetchAdImagesByReference($reference);
                        $advert['price'] = $mockRepository->fetchAdPriceByReference($reference);

                        $adverts[] = $advert;
                    }

                    Log::info("Ads of page $page fetched successfully.");

                    $page++;
                }
            } while ($references !== []);

            Log::info('All ads fetched successfully! Starting AdsFetchedFromMarketplace event.', ['import_id' => $this->import->id, 'ads' => print_r($adverts, true)]);

            event(new AdsFetchedFromMarketplace($adverts, $this->import));
        } catch (Exception $e) {
            Log::alert('Error while fetching ads', [
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
