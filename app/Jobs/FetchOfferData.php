<?php

namespace App\Jobs;

use App\Entities\Enums\ImportStatus;
use App\Entities\Import;
use App\Events\OfferFetched;
use App\UseCase\Contracts\Import\IImportUpdater;
use App\UseCase\Contracts\Offer\IOfferFinder;
use Exception;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class FetchOfferData implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected Import $import,
        protected int $ref
    ) {
    }

    public function handle()
    {
        try {
            $offerData = with(
                app(IOfferFinder::class),
                fn (IOfferFinder $gateway) => $gateway->fetchByRef($this->ref)
            );

            $offerData['images'] = with(
                app(IOfferFinder::class),
                fn (IOfferFinder $gateway) => $gateway->fetchImagesByRef($this->ref)
            );

            $offerData['price'] = with(
                app(IOfferFinder::class),
                fn (IOfferFinder $gateway) => $gateway->fetchPriceByRef($this->ref)
            );

            Log::info('Dados da oferta consultados com sucesso', $offerData);

            OfferFetched::dispatch($this->import, $offerData);
        } catch (Exception $e) {
            Log::alert('Erro ao consultar dados daoferta', [
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            with(
                app(IImportUpdater::class),
                fn (IImportUpdater $importService) => $importService->updateStatus($this->import->id, ImportStatus::FAILED)
            );
        }
    }
}
