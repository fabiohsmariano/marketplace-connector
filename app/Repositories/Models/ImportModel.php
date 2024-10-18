<?php

namespace App\Repositories\Models;

use App\Entities\Enums\ImportStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportModel extends Model
{
    use HasFactory;

    protected $table = 'imports';

    protected $fillable = [
        'status'
    ];

    protected $casts = [
        'status' => ImportStatus::class
    ];
}
