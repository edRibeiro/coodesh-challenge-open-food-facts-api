<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\ProductStatus;
use MongoDB\Laravel\Eloquent\Model;

class Produto extends Model
{
    /** @use HasFactory<\Database\Factories\ProdutoFactory> */
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'produtos';


    protected $casts = [
        'status' => ProductStatus::class, // Faz o cast para o enum
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['code', 'url', 'creator', 'created_t', 'last_modified_t', 'product_name', 'quantity', 'brands', 'categories', 'labels', 'cities', 'purchase_places', 'stores', 'ingredients_text', 'traces', 'serving_size', 'serving_quantity', 'nutriscore_score', 'nutriscore_grade', 'main_category', 'image_url', 'imported_t', 'status'];
}
