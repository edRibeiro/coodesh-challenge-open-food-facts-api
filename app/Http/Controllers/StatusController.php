<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller
{
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
