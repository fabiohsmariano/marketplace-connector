<?php

namespace App\UseCase\Import;

use App\Entities\Enums\ImportStatus;
use App\Entities\Import;
use App\Events\ImportCreated;
use App\UseCase\Contracts\Import\IImportUpdater;
use App\UseCase\Contracts\Repositories\IImportRepository;

class ImportUpdater implements IImportUpdater
{
    /**
     * ImportUpdater constructor.
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
    public function updateStatus(int $id, ImportStatus $status): Import
    {
        $import = $this->importRepository->update($id, [
            'status' => $status
        ]);

        return $import;
    }
}
