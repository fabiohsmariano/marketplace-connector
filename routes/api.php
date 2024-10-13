<?php

use App\Http\Controllers\ImportController;
use Illuminate\Support\Facades\Route;

Route::post('/imports', [ImportController::class, 'registerImport']);
