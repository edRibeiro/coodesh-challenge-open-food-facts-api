<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\ProductStatus;
use MongoDB\Laravel\Eloquent\Model;

/**
 * @OA\Schema(
 *   schema="Produto",
 *   title="Produto",
 *   description="Schema para o modelo Produto",
 *   @OA\Property(
 *     property="id",
 *     type="integer",
 *     description="ID único do produto"
 *   ),
 *   @OA\Property(
 *     property="code",
 *     type="string",
 *     description="Código único do produto"
 *   ),
 *   @OA\Property(
 *     property="status",
 *     type="string",
 *     enum={"draft", "trash", "published"},
 *     description="Status do produto"
 *   ),
 *   @OA\Property(
 *     property="url",
 *     type="string",
 *     description="URL do produto"
 *   ),
 *   @OA\Property(
 *     property="creator",
 *     type="string",
 *     description="Nome do criador do produto"
 *   ),
 *   @OA\Property(
 *     property="created_t",
 *     type="integer",
 *     description="Timestamp de criação"
 *   ),
 *   @OA\Property(
 *     property="last_modified_t",
 *     type="integer",
 *     description="Timestamp da última modificação"
 *   ),
 *   @OA\Property(
 *     property="product_name",
 *     type="string",
 *     description="Nome do produto"
 *   ),
 *   @OA\Property(
 *     property="quantity",
 *     type="string",
 *     nullable=true,
 *     description="Quantidade do produto"
 *   ),
 *   @OA\Property(
 *     property="brands",
 *     type="string",
 *     description="Marcas do produto"
 *   ),
 *   @OA\Property(
 *     property="categories",
 *     type="string",
 *     description="Categorias do produto"
 *   ),
 *   @OA\Property(
 *     property="labels",
 *     type="string",
 *     nullable=true,
 *     description="Rótulos do produto"
 *   ),
 *   @OA\Property(
 *     property="cities",
 *     type="string",
 *     nullable=true,
 *     description="Cidades onde o produto está disponível"
 *   ),
 *   @OA\Property(
 *     property="purchase_places",
 *     type="string",
 *     description="Locais de compra do produto"
 *   ),
 *   @OA\Property(
 *     property="stores",
 *     type="string",
 *     nullable=true,
 *     description="Lojas onde o produto está disponível"
 *   ),
 *   @OA\Property(
 *     property="ingredients_text",
 *     type="string",
 *     nullable=true,
 *     description="Ingredientes do produto"
 *   ),
 *   @OA\Property(
 *     property="traces",
 *     type="string",
 *     nullable=true,
 *     description="Traços e alergênicos do produto"
 *   ),
 *   @OA\Property(
 *     property="serving_size",
 *     type="string",
 *     description="Tamanho da porção do produto"
 *   ),
 *   @OA\Property(
 *     property="serving_quantity",
 *     type="number",
 *     format="float",
 *     description="Quantidade por porção"
 *   ),
 *   @OA\Property(
 *     property="nutriscore_score",
 *     type="integer",
 *     description="Pontuação Nutri-Score"
 *   ),
 *   @OA\Property(
 *     property="nutriscore_grade",
 *     type="string",
 *     maxLength=1,
 *     description="Grau Nutri-Score (A, B, C, etc.)"
 *   ),
 *   @OA\Property(
 *     property="main_category",
 *     type="string",
 *     description="Categoria principal do produto"
 *   ),
 *   @OA\Property(
 *     property="image_url",
 *     type="string",
 *     description="URL da imagem do produto"
 *   ),
 *   @OA\Property(
 *     property="imported_t",
 *     type="string",
 *     format="date-time",
 *     description="Data e hora de importação do produto"
 *   )
 * )
 */
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
