<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller
{
    /**
     * @OA\Get(
     *     path="/",
     *     tags={"API"},
     *     summary="Detalhes da API",
     *     description="Detalhes da API, se conexão leitura e escrita com a base de dados está OK, horário da última vez que o CRON foi executado, tempo online e uso de memória.",
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes da API retornados com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="api_version",
     *                 type="string",
     *                 description="Versão da API"
     *             ),
     *             @OA\Property(
     *                 property="database_connection",
     *                 type="object",
     *                 @OA\Property(
     *                     property="read",
     *                     type="boolean",
     *                     description="Status da conexão de leitura com a base de dados"
     *                 ),
     *                 @OA\Property(
     *                     property="write",
     *                     type="boolean",
     *                     description="Status da conexão de escrita com a base de dados"
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="last_cron_run",
     *                 type="string",
     *                 format="date-time",
     *                 description="Horário da última execução do CRON"
     *             ),
     *             @OA\Property(
     *                 property="uptime",
     *                 type="string",
     *                 description="Tempo online da aplicação"
     *             ),
     *             @OA\Property(
     *                 property="memory_usage",
     *                 type="string",
     *                 description="Uso de memória da aplicação em bytes"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro interno do servidor"
     *     )
     * )
     */
    public function status()
    {
        $status = [
            'api_version' => '1.0.0',
            'database_connection' => $this->checkDatabaseConnection(),
            'last_cron_run' => Cache::get('last_cron_run', 'Não executado'),
            'uptime' => $this->getUptime(),
            'memory_usage' => $this->getMemoryUsage()
        ];

        return response()->json($status);
    }

    private function checkDatabaseConnection()
    {
        try {
            DB::connection()->getPdo();
            return [
                'read' => true,
                'write' => DB::connection()->getDatabaseName() ? true : false
            ];
        } catch (\Exception $e) {
            return [
                'read' => false,
                'write' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    private function getUptime()
    {
        if (file_exists('/proc/uptime')) {
            $uptime = file_get_contents('/proc/uptime');
            $uptime = explode(' ', $uptime)[0];
            return gmdate("H:i:s", (int)$uptime);
        }
        return 'Indisponível';
    }

    private function getMemoryUsage()
    {
        return memory_get_usage(true) . ' bytes';
    }
}
