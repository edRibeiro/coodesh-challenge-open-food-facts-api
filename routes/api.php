<?php

use App\Http\Controllers\ProdutoController;
use Illuminate\Support\Facades\Route;

Route::controller(ProdutoController::class)->group(function () {
    Route::get('/products', 'index');
    Route::get('/products/{code}', 'show')->where('code', '[0-9]+');;
    Route::put('/products/{code}', 'update')->where('code', '[0-9]+');;
    Route::delete('/products/{code}', 'destroy')->where('code', '[0-9]+');;
});
