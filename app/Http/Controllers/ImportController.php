<?php

namespace App\Http\Controllers;

use App\Services\ImportService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ImportController extends Controller
{
    public function __construct(
        public ImportService $service
    ) {
    }

    /**
     * Create a new import record and dispatch a job to import offers.
     *
     * @return JsonResponse
     */
    public function registerImport(): JsonResponse
    {
        try {
            $this->service->handle();

            return response()->json([
                'message' => 'Importação agendada com sucesso!'
            ], Response::HTTP_ACCEPTED);
        } catch (Exception $e) {
            Log::alert('Error scheduling import', [
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Erro ao agendar importação. Tente novamente mais tarde.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
