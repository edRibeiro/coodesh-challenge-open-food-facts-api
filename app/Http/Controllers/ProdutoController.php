<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProdutoRequest;
use App\Http\Resources\ProdutoCollection;
use App\Http\Resources\ProdutoResource;
use App\Models\Produto;
use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * @OA\Get(
     *     path="/api/products",
     *     tags={"Products"},
     *     summary="Retrieves a list of products",
     *     @OA\Response(
     *         response=200,
     *         description="A list of products retrieved successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="code",
     *                         type="string",
     *                         example="4000400156570"
     *                     ),
     *                     @OA\Property(
     *                         property="url",
     *                         type="string",
     *                         format="uri",
     *                         example="http://world-en.openfoodfacts.org/product/4000400156570/preparado-para-hacer-tortitas-maizena"
     *                     ),
     *                     @OA\Property(
     *                         property="creator",
     *                         type="string",
     *                         example="kiliweb"
     *                     ),
     *                     @OA\Property(
     *                         property="created_t",
     *                         type="integer",
     *                         example=1516291652
     *                     ),
     *                     @OA\Property(
     *                         property="last_modified_t",
     *                         type="integer",
     *                         example=1610544808
     *                     ),
     *                     @OA\Property(
     *                         property="product_name",
     *                         type="string",
     *                         example="Preparado para hacer tortitas"
     *                     ),
     *                     @OA\Property(
     *                         property="quantity",
     *                         type="string",
     *                         example=""
     *                     ),
     *                     @OA\Property(
     *                         property="brands",
     *                         type="string",
     *                         example="Maizena"
     *                     ),
     *                     @OA\Property(
     *                         property="categories",
     *                         type="string",
     *                         example=""
     *                     ),
     *                     @OA\Property(
     *                         property="labels",
     *                         type="string",
     *                         example=""
     *                     ),
     *                     @OA\Property(
     *                         property="cities",
     *                         type="string",
     *                         example=""
     *                     ),
     *                     @OA\Property(
     *                         property="purchase_places",
     *                         type="string",
     *                         example=""
     *                     ),
     *                     @OA\Property(
     *                         property="stores",
     *                         type="string",
     *                         example=""
     *                     ),
     *                     @OA\Property(
     *                         property="ingredients_text",
     *                         type="string",
     *                         example=""
     *                     ),
     *                     @OA\Property(
     *                         property="traces",
     *                         type="string",
     *                         example=""
     *                     ),
     *                     @OA\Property(
     *                         property="serving_size",
     *                         type="string",
     *                         example=""
     *                     ),
     *                     @OA\Property(
     *                         property="serving_quantity",
     *                         type="string",
     *                         example=""
     *                     ),
     *                     @OA\Property(
     *                         property="nutriscore_score",
     *                         type="string",
     *                         example=""
     *                     ),
     *                     @OA\Property(
     *                         property="nutriscore_grade",
     *                         type="string",
     *                         example=""
     *                     ),
     *                     @OA\Property(
     *                         property="main_category",
     *                         type="string",
     *                         example=""
     *                     ),
     *                     @OA\Property(
     *                         property="image_url",
     *                         type="string",
     *                         format="uri",
     *                         example="https://static.openfoodfacts.org/images/products/400/040/015/6570/front_fr.15.400.jpg"
     *                     ),
     *                     @OA\Property(
     *                         property="status",
     *                         type="string",
     *                         example="published"
     *                     ),
     *                     @OA\Property(
     *                         property="imported_t",
     *                         type="string",
     *                         format="date-time",
     *                         example="2024-11-05T02:10:37.638000Z"
     *                     ),
     *                     @OA\Property(
     *                         property="updated_at",
     *                         type="string",
     *                         format="date-time",
     *                         example="2024-11-05T02:10:37.818000Z"
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         format="date-time",
     *                         example="2024-11-05T02:10:37.818000Z"
     *                     ),
     *                     @OA\Property(
     *                         property="id",
     *                         type="string",
     *                         example="67297e9df4c37a710d06bac5"
     *                     )
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="links",
     *                 type="object",
     *                 @OA\Property(
     *                     property="first",
     *                     type="string",
     *                     example="http://localhost/api/products?page=1"
     *                 ),
     *                 @OA\Property(
     *                     property="last",
     *                     type="string",
     *                     example="http://localhost/api/products?page=47"
     *                 ),
     *                 @OA\Property(
     *                     property="prev",
     *                     type="string",
     *                     nullable=true,
     *                     example=null
     *                 ),
     *                 @OA\Property(
     *                     property="next",
     *                     type="string",
     *                     example="http://localhost/api/products?page=2"
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="meta",
     *                 type="object",
     *                 @OA\Property(
     *                     property="current_page",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="from",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="last_page",
     *                     type="integer",
     *                     example=47
     *                 ),
     *                 @OA\Property(
     *                     property="links",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="url", type="string", nullable=true),
     *                         @OA\Property(property="label", type="string"),
     *                         @OA\Property(property="active", type="boolean")
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="path",
     *                     type="string",
     *                     example="http://localhost/api/products"
     *                 ),
     *                 @OA\Property(
     *                     property="per_page",
     *                     type="integer",
     *                     example=15
     *                 ),
     *                 @OA\Property(
     *                     property="to",
     *                     type="integer",
     *                     example=15
     *                 ),
     *                 @OA\Property(
     *                     property="total",
     *                     type="integer",
     *                     example=699
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        return new ProdutoCollection(Produto::where("status", "=", ProductStatus::PUBLISHED)->paginate());
    }

    /**
     * Display the specified resource.
     */
    /**
     * @OA\Get(
     *     path="/api/products/{code}",
     *     tags={"Products"},
     *     summary="Retrieve a product by its code",
     *     @OA\Parameter(
     *         name="code",
     *         in="path",
     *         required=true,
     *         description="The code of the product to retrieve.",
     *         @OA\Schema(
     *             type="string",
     *             example="4000400156570"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A product retrieved successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="code",
     *                     type="string",
     *                     example="4000400156570"
     *                 ),
     *                 @OA\Property(
     *                     property="url",
     *                     type="string",
     *                     format="uri",
     *                     example="http://world-en.openfoodfacts.org/product/4000400156570/preparado-para-hacer-tortitas-maizena"
     *                 ),
     *                 @OA\Property(
     *                     property="creator",
     *                     type="string",
     *                     example="kiliweb"
     *                 ),
     *                 @OA\Property(
     *                     property="created_t",
     *                     type="integer",
     *                     example=1516291652
     *                 ),
     *                 @OA\Property(
     *                     property="last_modified_t",
     *                     type="integer",
     *                     example=1610544808
     *                 ),
     *                 @OA\Property(
     *                     property="product_name",
     *                     type="string",
     *                     example="Preparado para hacer tortitas"
     *                 ),
     *                 @OA\Property(
     *                     property="quantity",
     *                     type="string",
     *                     example=""
     *                 ),
     *                 @OA\Property(
     *                     property="brands",
     *                     type="string",
     *                     example="Maizena"
     *                 ),
     *                 @OA\Property(
     *                     property="categories",
     *                     type="string",
     *                     example=""
     *                 ),
     *                 @OA\Property(
     *                     property="labels",
     *                     type="string",
     *                     example=""
     *                 ),
     *                 @OA\Property(
     *                     property="cities",
     *                     type="string",
     *                     example=""
     *                 ),
     *                 @OA\Property(
     *                     property="purchase_places",
     *                     type="string",
     *                     example=""
     *                 ),
     *                 @OA\Property(
     *                     property="stores",
     *                     type="string",
     *                     example=""
     *                 ),
     *                 @OA\Property(
     *                     property="ingredients_text",
     *                     type="string",
     *                     example=""
     *                 ),
     *                 @OA\Property(
     *                     property="traces",
     *                     type="string",
     *                     example=""
     *                 ),
     *                 @OA\Property(
     *                     property="serving_size",
     *                     type="string",
     *                     example=""
     *                 ),
     *                 @OA\Property(
     *                     property="serving_quantity",
     *                     type="string",
     *                     example=""
     *                 ),
     *                 @OA\Property(
     *                     property="nutriscore_score",
     *                     type="string",
     *                     example=""
     *                 ),
     *                 @OA\Property(
     *                     property="nutriscore_grade",
     *                     type="string",
     *                     example=""
     *                 ),
     *                 @OA\Property(
     *                     property="main_category",
     *                     type="string",
     *                     example=""
     *                 ),
     *                 @OA\Property(
     *                     property="image_url",
     *                     type="string",
     *                     format="uri",
     *                     example="https://static.openfoodfacts.org/images/products/400/040/015/6570/front_fr.15.400.jpg"
     *                 ),
     *                 @OA\Property(
     *                     property="status",
     *                     type="string",
     *                     example="published"
     *                 ),
     *                 @OA\Property(
     *                     property="imported_t",
     *                     type="string",
     *                     format="date-time",
     *                     example="2024-11-05T02:10:37.638000Z"
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     format="date-time",
     *                     example="2024-11-05T02:10:37.818000Z"
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     format="date-time",
     *                     example="2024-11-05T02:10:37.818000Z"
     *                 ),
     *                 @OA\Property(
     *                     property="id",
     *                     type="string",
     *                     example="67297e9df4c37a710d06bac5"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function show(string $code)
    {
        try {
            $produto = Produto::where('code', (int) $code)->where("status", "=", ProductStatus::PUBLISHED)->first();
            if (!$produto) {
                throw new ModelNotFoundException();
            }
            return new ProdutoResource($produto);
        } catch (ModelNotFoundException $th) {
            return response()->json(Response::$statusTexts[Response::HTTP_NOT_FOUND], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * @OA\Put(
     *     path="/products/{code}",
     *     summary="Atualiza um produto existente",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="code",
     *         in="path",
     *         required=true,
     *         description="Código do produto a ser atualizado",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="url", type="string", example="http://world-en.openfoodfacts.org/product/0073490180286/absolutely-gluten-free-classic-coconut-macaroons-toasted-coconut-royal-wine-corporation"),
     *                 @OA\Property(property="creator", type="string", example="usda-ndb-import"),
     *                 @OA\Property(property="product_name", type="string", example="Absolutely, Gluten Free Classic Coconut Macaroons, Toasted Coconut"),
     *                 @OA\Property(property="quantity", type="string", example=""),
     *                 @OA\Property(property="brands", type="string", example="Royal Wine Corporation"),
     *                 @OA\Property(property="categories", type="string", example="Snacks, Sweet snacks, Biscuits and cakes, Biscuits, Pastries, Coconut Macaroons"),
     *                 @OA\Property(property="labels", type="string", example=""),
     *                 @OA\Property(property="cities", type="string", example=""),
     *                 @OA\Property(property="purchase_places", type="string", example=""),
     *                 @OA\Property(property="stores", type="string", example=""),
     *                 @OA\Property(property="ingredients_text", type="string", example="Unsweetened sulfite free coconut, invert sugar, tapioca, egg whites."),
     *                 @OA\Property(property="traces", type="string", example=""),
     *                 @OA\Property(property="serving_size", type="string", example="2 MACAROONS (28 g)"),
     *                 @OA\Property(property="serving_quantity", type="integer", example=28),
     *                 @OA\Property(property="nutriscore_score", type="integer", example=21),
     *                 @OA\Property(property="nutriscore_grade", type="string", example="e"),
     *                 @OA\Property(property="main_category", type="string", example="en:coconut-macaroons"),
     *                 @OA\Property(property="image_url", type="string", example=""),
     *                 @OA\Property(property="status", type="string", example="trash", enum={"draft", "trash", "published"})
     *             )
     *         )
     *     ),
     * *     @OA\Response(
     *         response=200,
     *         description="A product retrieved successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="code",
     *                     type="string",
     *                     example="4000400156570"
     *                 ),
     *                 @OA\Property(
     *                     property="url",
     *                     type="string",
     *                     format="uri",
     *                     example="http://world-en.openfoodfacts.org/product/4000400156570/preparado-para-hacer-tortitas-maizena"
     *                 ),
     *                 @OA\Property(
     *                     property="creator",
     *                     type="string",
     *                     example="kiliweb"
     *                 ),
     *                 @OA\Property(
     *                     property="created_t",
     *                     type="integer",
     *                     example=1516291652
     *                 ),
     *                 @OA\Property(
     *                     property="last_modified_t",
     *                     type="integer",
     *                     example=1610544808
     *                 ),
     *                 @OA\Property(
     *                     property="product_name",
     *                     type="string",
     *                     example="Preparado para hacer tortitas"
     *                 ),
     *                 @OA\Property(
     *                     property="quantity",
     *                     type="string",
     *                     example=""
     *                 ),
     *                 @OA\Property(
     *                     property="brands",
     *                     type="string",
     *                     example="Maizena"
     *                 ),
     *                 @OA\Property(
     *                     property="categories",
     *                     type="string",
     *                     example=""
     *                 ),
     *                 @OA\Property(
     *                     property="labels",
     *                     type="string",
     *                     example=""
     *                 ),
     *                 @OA\Property(
     *                     property="cities",
     *                     type="string",
     *                     example=""
     *                 ),
     *                 @OA\Property(
     *                     property="purchase_places",
     *                     type="string",
     *                     example=""
     *                 ),
     *                 @OA\Property(
     *                     property="stores",
     *                     type="string",
     *                     example=""
     *                 ),
     *                 @OA\Property(
     *                     property="ingredients_text",
     *                     type="string",
     *                     example=""
     *                 ),
     *                 @OA\Property(
     *                     property="traces",
     *                     type="string",
     *                     example=""
     *                 ),
     *                 @OA\Property(
     *                     property="serving_size",
     *                     type="string",
     *                     example=""
     *                 ),
     *                 @OA\Property(
     *                     property="serving_quantity",
     *                     type="string",
     *                     example=""
     *                 ),
     *                 @OA\Property(
     *                     property="nutriscore_score",
     *                     type="string",
     *                     example=""
     *                 ),
     *                 @OA\Property(
     *                     property="nutriscore_grade",
     *                     type="string",
     *                     example=""
     *                 ),
     *                 @OA\Property(
     *                     property="main_category",
     *                     type="string",
     *                     example=""
     *                 ),
     *                 @OA\Property(
     *                     property="image_url",
     *                     type="string",
     *                     format="uri",
     *                     example="https://static.openfoodfacts.org/images/products/400/040/015/6570/front_fr.15.400.jpg"
     *                 ),
     *                 @OA\Property(
     *                     property="status",
     *                     type="string",
     *                     example="published"
     *                 ),
     *                 @OA\Property(
     *                     property="imported_t",
     *                     type="string",
     *                     format="date-time",
     *                     example="2024-11-05T02:10:37.638000Z"
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     format="date-time",
     *                     example="2024-11-05T02:10:37.818000Z"
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     format="date-time",
     *                     example="2024-11-05T02:10:37.818000Z"
     *                 ),
     *                 @OA\Property(
     *                     property="id",
     *                     type="string",
     *                     example="67297e9df4c37a710d06bac5"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produto não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Produto não encontrado.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="status", type="array", @OA\Items(type="string")),
     *                 @OA\Property(property="url", type="array", @OA\Items(type="string")),
     *                 @OA\Property(property="creator", type="array", @OA\Items(type="string")),
     *                 @OA\Property(property="product_name", type="array", @OA\Items(type="string")),
     *                 @OA\Property(property="brands", type="array", @OA\Items(type="string")),
     *                 @OA\Property(property="categories", type="array", @OA\Items(type="string")),
     *                 @OA\Property(property="labels", type="array", @OA\Items(type="string")),
     *                 @OA\Property(property="cities", type="array", @OA\Items(type="string")),
     *                 @OA\Property(property="purchase_places", type="array", @OA\Items(type="string")),
     *                 @OA\Property(property="stores", type="array", @OA\Items(type="string")),
     *                 @OA\Property(property="ingredients_text", type="array", @OA\Items(type="string")),
     *                 @OA\Property(property="traces", type="array", @OA\Items(type="string")),
     *                 @OA\Property(property="serving_size", type="array", @OA\Items(type="string")),
     *                 @OA\Property(property="serving_quantity", type="array", @OA\Items(type="string")),
     *                 @OA\Property(property="nutriscore_score", type="array", @OA\Items(type="string")),
     *                 @OA\Property(property="nutriscore_grade", type="array", @OA\Items(type="string")),
     *                 @OA\Property(property="main_category", type="array", @OA\Items(type="string")),
     *                 @OA\Property(property="image_url", type="array", @OA\Items(type="string"))
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro interno do servidor",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Erro ao atualizar o produto.")
     *         )
     *     )
     * )
     */
    public function update(UpdateProdutoRequest $request, string $code)
    {
        try {
            $produto = Produto::where('code', (int) $code)->where("status", "=", ProductStatus::PUBLISHED)->first();
            if (!$produto) {
                throw new ModelNotFoundException();
            }
            $produto->update($request->validated());
            return new ProdutoResource($produto);
        } catch (ModelNotFoundException $th) {
            return response()->json(Response::$statusTexts[Response::HTTP_NOT_FOUND], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Tratamento para outros erros não esperados
            return response()->json(
                ['error' => 'Erro ao atualizar o produto.'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * @OA\Delete(
     *     path="/products/{code}",
     *     summary="Remove um produto existente",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="code",
     *         in="path",
     *         required=true,
     *         description="Código do produto a ser removido",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Produto removido com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produto não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Produto não encontrado.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro interno do servidor",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Erro ao remover o produto.")
     *         )
     *     )
     * )
     */
    public function destroy(string $code)
    {
        try {
            $produto = Produto::where('code', (int) $code)->where("status", "=", ProductStatus::PUBLISHED)->first();
            if (!$produto) {
                throw new ModelNotFoundException();
            }
            $produto->status = ProductStatus::DRAFT;
            $produto->save();
            return response()->noContent();
        } catch (ModelNotFoundException $th) {
            return response()->json(Response::$statusTexts[Response::HTTP_NOT_FOUND], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            // Tratamento para outros erros não esperados
            return response()->json(
                ['error' => 'Erro ao atualizar o produto.'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
