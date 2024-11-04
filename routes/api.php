<?php

use App\Http\Controllers\ProdutoController;
use Illuminate\Support\Facades\Route;

Route::controller(ProdutoController::class)->group(function () {
    Route::get('/products', 'index');
    Route::get('/products/{code}', 'show');
    Route::put('/products/{code}', 'update');
    Route::delete('/products/{code}', 'destroy');
});
