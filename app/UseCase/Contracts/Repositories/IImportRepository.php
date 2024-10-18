<?php

namespace App\UseCase\Contracts\Repositories;

use App\Entities\Import;

interface IImportRepository
{
    /**
     * Busca um registro de importação
     *
     * @param int $id
     * @return Import|null
     */
    public function find(int $id): ?Import;

    /**
     * Cria um registro de importação
     *
     * @return Import
     */
    public function create(): Import;

    /**
     * Atualiza um registro de importação
     *
     * @param int   $id
     * @param array $data
     * @return Import|null
     */
    public function update(int $id, array $data): ?Import;
}
