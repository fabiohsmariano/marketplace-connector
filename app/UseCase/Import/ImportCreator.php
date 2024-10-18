<?php

namespace App\UseCase\Import;

use App\Events\ImportCreated;
use App\UseCase\Contracts\Import\IImportCreator;
use App\UseCase\Contracts\Repositories\IImportRepository;

class ImportCreator implements IImportCreator
{
    /**
     * ImportCreator constructor.
     *
     * @param IImportRepository $importRepository
     */
    public function __construct(
        protected IImportRepository $importRepository
    ) {
    }

    /**
     * @inheritDoc
     */
    public function create(): void
    {
        $import = $this->importRepository->create();

        ImportCreated::dispatch($import);
    }
}
