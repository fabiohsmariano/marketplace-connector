<?php

namespace App\UseCase\Import;

use App\UseCase\Contracts\Import\IImportCreator;
use App\UseCase\Contracts\Import\IImportManager;
use Illuminate\Support\Facades\Log;

class ImportManager implements IImportManager
{
    /**
     * @inheritDoc
     */
    public function handle(): void
    {
        with(
            app(IImportCreator::class),
            fn (IImportCreator $importCreator) => $importCreator->create()
        );

        Log::info('Importação criada com sucesso.');
    }
}
