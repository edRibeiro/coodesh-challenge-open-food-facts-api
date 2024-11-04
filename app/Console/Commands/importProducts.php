<?php

namespace App\Console\Commands;

use App\Jobs\FecthProductsImportFile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class importProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para importar produdos.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Cache::put('last_cron_run', now()->toDateTimeString());
        $url = 'https://challenges.coode.sh/food/data/json/index.txt'; // IMPORT_URL
        $response = Http::get($url);
        if ($response->successful()) {
            $conteudo = $response->body();
            $linhas = explode(PHP_EOL, $conteudo);
            foreach ($linhas as $key => $fileName) {
                if (DB::table('files_imported')->where('file_name', '=', $fileName)->doesntExist() && !empty($fileName)) {
                    FecthProductsImportFile::dispatch($fileName);
                    DB::table('files_imported')->insert(['file_name' => $fileName]);
                }
            }
        } else {
            $this->error('Não foi possível ler o arquivo.');
            return 1;
        }
        return 0;
    }
}
