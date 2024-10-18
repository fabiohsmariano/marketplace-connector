<?php

namespace App\Http\Controllers;

use App\UseCase\Contracts\Import\IImportManager;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ImportController extends Controller
{
    /**
     * Create a new import record and dispatch a job to import offers.
     *
     * @return JsonResponse
     */
    public function registerImport(): JsonResponse
    {
        try {
            Log::info('Solicitação de importação recebida');

            with(
                app(IImportManager::class),
                fn (IImportManager $manager) => $manager->handle()
            );

            return response()->json([
                'message' => 'Importação agendada com sucesso!'
            ], Response::HTTP_ACCEPTED);
        } catch (Exception $e) {
            Log::alert('Erro ao agendar importação', [
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'message' => 'Erro ao agendar importação. Tente novamente mais tarde.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
