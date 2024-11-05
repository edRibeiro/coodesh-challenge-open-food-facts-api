<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * @OA\Schema(
 *     title="UpdateProdutoRequest",
 *     description="Requisição para atualizar um produto",
 *     type="object",
 *     required={"product_name", "brands", "categories", "ingredients_text", "serving_size", "serving_quantity", "nutriscore_score", "nutriscore_grade", "main_category"}
 * )
 */
class UpdateProdutoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => 'sometimes|in:draft,trash,published',
            'url' => 'sometimes|url',
            'creator' => 'sometimes|string',
            'product_name' => 'sometimes|string',
            'quantity' => 'sometimes|string',
            'brands' => 'sometimes|string',
            'categories' => 'sometimes|string',
            'labels' => 'sometimes|string',
            'cities' => 'nullable|string',
            'purchase_places' => 'sometimes|string',
            'stores' => 'sometimes|string',
            'ingredients_text' => 'sometimes|string',
            'traces' => 'nullable|string',
            'serving_size' => 'sometimes|string',
            'serving_quantity' => 'sometimes|numeric|min:0',
            'nutriscore_score' => 'sometimes|integer|min:0',
            'nutriscore_grade' => 'sometimes|string|size:1|in:a,b,c,d,e',
            'main_category' => 'sometimes|string',
            'image_url' => 'nullable|url',
        ];
    }

    /**
     * @OA\Response(
     *     response=422,
     *     description="Erro de validação",
     *     @OA\JsonContent(
     *         @OA\Property(property="errors", type="object",
     *             @OA\Property(property="status", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="url", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="creator", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="product_name", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="brands", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="categories", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="labels", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="cities", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="purchase_places", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="stores", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="ingredients_text", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="traces", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="serving_size", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="serving_quantity", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="nutriscore_score", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="nutriscore_grade", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="main_category", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="image_url", type="array", @OA\Items(type="string")),
     *         )
     *     )
     * )
     */
    public function messages()
    {
        return [
            'status.sometimes' => 'O status é obrigatório.',
            'status.in' => 'O status deve ser um dos seguintes: draft, trash, published.',
            'url.sometimes' => 'A URL é obrigatória.',
            'url.url' => 'A URL deve ser um endereço válido.',
            'creator.sometimes' => 'O criador é obrigatório.',
            'creator.string' => 'O criador deve ser uma string.',
            'product_name.sometimes' => 'O nome do produto é obrigatório.',
            'quantity.sometimes' => 'A quantidade é obrigatória.',
            'brands.sometimes' => 'As marcas são obrigatórias.',
            'categories.sometimes' => 'As categorias são obrigatórias.',
            'labels.sometimes' => 'Os rótulos são obrigatórios.',
            'cities.string' => 'As cidades devem ser uma string.',
            'purchase_places.sometimes' => 'Os locais de compra são obrigatórios.',
            'stores.sometimes' => 'As lojas são obrigatórias.',
            'ingredients_text.sometimes' => 'O texto dos ingredientes é obrigatório.',
            'traces.string' => 'Os traços devem ser uma string.',
            'serving_size.sometimes' => 'O tamanho da porção é obrigatório.',
            'serving_quantity.sometimes' => 'A quantidade da porção é obrigatória.',
            'serving_quantity.numeric' => 'A quantidade da porção deve ser um número.',
            'nutriscore_score.sometimes' => 'A pontuação Nutriscore é obrigatória.',
            'nutriscore_score.integer' => 'A pontuação Nutriscore deve ser um número inteiro.',
            'nutriscore_grade.sometimes' => 'A nota Nutriscore é obrigatória.',
            'nutriscore_grade.size' => 'A nota Nutriscore deve ter 1 caractere.',
            'main_category.sometimes' => 'A categoria principal é obrigatória.',
            'image_url.url' => 'A URL da imagem deve ser um endereço válido.',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.*
     * @return array
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors()
        ], 422));
    }
}
