<?php

namespace App\Jobs;

use App\Entities\Enums\ImportStatus;
use App\Entities\Import;
use App\UseCase\Contracts\Import\IImportUpdater;
use App\UseCase\Contracts\Offer\IOfferFinder;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class FetchOfferReferences implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected Import $import,
        protected int $page
    ) {
    }

    public function handle()
    {
        try {
            if ($this->import->status !== ImportStatus::IN_PROGRESS) {
                $this->import = with(
                    app(IImportUpdater::class),
                    fn (IImportUpdater $importService) => $importService->updateStatus($this->import->id, ImportStatus::IN_PROGRESS)
                );
            }

            Log::info('Início da consulta das referências das ofertas.');

            $offerReferences = with(
                app(IOfferFinder::class),
                fn (IOfferFinder $finder) => $finder->fetchReferences($this->page)
            );

            foreach ($offerReferences as $ref) {
                FetchOfferData::dispatch($this->import, $ref);
            }

            FetchOfferReferences::dispatch($this->import, $this->page + 1);
        } catch (Exception $e) {
            Log::alert('Erro na consulta das referências das ofertas', [
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'message' => $e->getMessage()
            ]);

            with(
                app(IImportUpdater::class),
                fn (IImportUpdater $importService) => $importService->updateStatus($this->import->id, ImportStatus::FAILED)
            );
        }
    }
}
