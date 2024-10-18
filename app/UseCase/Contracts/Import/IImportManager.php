<?php

namespace App\UseCase\Contracts\Import;

interface IImportManager
{
    /**
     * Trata a importação.
     *
     * @return void
     */
    public function handle(): void;
}
