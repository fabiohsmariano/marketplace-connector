<?php

namespace App\Enums;

enum ImportStatus: string
{
    case PENDING = 'pending';
    case IN_PROGRESS = 'processing';
    case COMPLETED = 'completed';
    case FAILED = 'failed';
}
