<?php

namespace App\Repositories;

use App\Entities\Import;
use App\Repositories\Models\ImportModel;
use App\UseCase\Contracts\Repositories\IImportRepository;

class ImportRepository implements IImportRepository
{
    /**
     * O modelo de importação
     *
     * @var ImportModel|null $model
     */
    protected ?ImportModel $model = null;

    /**
     * Busca um registro de importação
     *
     * @param int $id
     * @return Import|null
     */
    public function find(int $id): ?Import
    {
        $import = $this->getModel()->find($id);

        if (!$import) {
            return null;
        }

        return $this->toEntity($import);
    }

    /**
     * Cria um registro de importação
     *
     * @return Import
     */
    public function create(): Import
    {
        $import = $this->getModel()->create();

        return $this->toEntity($import);
    }

    /**
     * Atualiza um registro de importação
     *
     * @param int   $id
     * @param array $data
     * @return Import|null
     */
    public function update(int $id, array $data): ?Import
    {
        $import = $this->getModel()->find($id);

        if (!$import) {
            return null;
        }

        $import->update($data);

        return $this->toEntity($import);
    }

    /**
     * Retorna o model
     *
     * @return ImportModel
     */
    protected function getModel(): ImportModel
    {
        if (is_null($this->model)) {
            $this->model = app(ImportModel::class);
        }

        return $this->model;
    }

    /**
     * Transforma model em entidade
     *
     * @param ImportModel $model
     * @return Import
     */
    protected function toEntity(ImportModel $model): Import
    {
        return new Import($model->toArray());
    }
}
