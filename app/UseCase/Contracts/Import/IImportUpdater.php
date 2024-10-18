<?php

namespace App\UseCase\Contracts\Import;

use App\Entities\Enums\ImportStatus;
use App\Entities\Import;

interface IImportUpdater
{
    /**
     * Atualiza o status da importação
     *
     * @param int $id
     * @param ImportStatus $status
     * @return Import
     */
    public function updateStatus(int $id, ImportStatus $status): Import;
}
