<?php

namespace App\Jobs;

use App\Entities\Enums\ImportStatus;
use App\Entities\Import;
use App\UseCase\Contracts\Hub\IHubSender;
use App\UseCase\Contracts\Import\IImportUpdater;
use Exception;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendOffer implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected Import $import,
        protected array $offer
    ) {
    }

    public function handle()
    {
        try {
            with(
                app(IHubSender::class),
                fn (IHubSender $sender) => $sender->send($this->offer)
            );

            with(
                app(IImportUpdater::class),
                fn (IImportUpdater $importService) => $importService->updateStatus($this->import->id, ImportStatus::COMPLETED)
            );

            Log::info('Oferta enviada ao Hub com sucesso.');
        } catch (Exception $e) {
            Log::alert('Erro ao enviar oferta ao hub', [
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
