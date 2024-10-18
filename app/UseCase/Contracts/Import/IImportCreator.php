<?php

namespace App\UseCase\Contracts\Import;

interface IImportCreator
{
    /**
     * Cria um novo registro de importação
     *
     * @return void
     */
    public function create(): void;
}
