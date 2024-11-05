<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'nutriscore_grade' => 'sometimes|string|size:1|in:A,B,C,D,E',
            'main_category' => 'sometimes|string',
            'image_url' => 'nullable|url',
        ];
    }

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
