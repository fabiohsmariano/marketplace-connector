<?php

namespace App\Entities;

use App\Entities\Enums\ImportStatus;

/**
 * @property int    $id
 * @property ImportStatus $status
 */
class Import
{
    public function __construct(array $attributes = [])
    {
        $this->id     = $attributes['id']     ?? null;
        $this->status = $attributes['status'] ?? null;
    }

    public function toArray(): array
    {
        return [
            'id'     => $this->id,
            'status' => $this->status
        ];
    }
}
