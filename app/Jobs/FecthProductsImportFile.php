<?php

namespace App\Jobs;

use App\Helpers\ProductTransform;
use App\Models\Produto;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FecthProductsImportFile implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private string $fileName)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $gzUrl = "https://challenges.coode.sh/food/data/json/$this->fileName";
        $response = Http::get($gzUrl);
        $compressedContent = $response->getBody()->getContents();

        $tempFile = tempnam(sys_get_temp_dir(), 'gzfile');
        file_put_contents($tempFile, $compressedContent);
        $gzHandle = gzopen($tempFile, 'r');
        if ($gzHandle) {
            DB::transaction(function () use ($gzHandle) {
                $index = 0;
                while (($line = gzgets($gzHandle)) !== false && $index < 100) {
                    $productData = json_decode($line);
                    try {
                        Produto::create([
                            'code' => (int) preg_replace('/\D/', '', $productData->code),
                            'url' => $productData->url,
                            'creator' => $productData->creator,
                            'created_t' => $productData->created_t,
                            'last_modified_t' => $productData->last_modified_t,
                            'product_name' => $productData->product_name,
                            'quantity' => $productData->quantity,
                            'brands' => $productData->brands,
                            'categories' => $productData->categories,
                            'labels' => $productData->labels,
                            'cities' => $productData->cities,
                            'purchase_places' => $productData->purchase_places,
                            'stores' => $productData->stores,
                            'ingredients_text' => $productData->ingredients_text,
                            'traces' => $productData->traces,
                            'serving_size' => $productData->serving_size,
                            'serving_quantity' => $productData->serving_quantity,
                            'nutriscore_score' => $productData->nutriscore_score,
                            'nutriscore_grade' => $productData->nutriscore_grade,
                            'main_category' => $productData->main_category,
                            'image_url' => $productData->image_url,
                            'status' => 'published',
                            'imported_t' => now()
                        ]);
                    } catch (\Throwable $th) {
                        Log::error("Failed to import product: " . json_encode($productData) . ". Error: " . $th->getMessage());
                    }
                    $index++;
                }
            });
            gzclose($gzHandle);
            DB::table('files_imported')->insert(['file_name' => $this->fileName]);
        }
        unlink($tempFile);
    }
}
