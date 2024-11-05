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
    public function index()
    {
        return new ProdutoCollection(Produto::where("status", "=", ProductStatus::PUBLISHED)->paginate());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $code)
    {
        try {
            // dd($code);
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
