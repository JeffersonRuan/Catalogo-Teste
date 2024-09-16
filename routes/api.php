<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\ProdutoController;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

Route::post('/logout', function (Request $request) {
    auth()->logout();
    return response()->json(['message' => 'Logout realizado com sucesso']);
});

Route::get('auth/check', function () {
    return response()->json(['authenticated' => auth()->check()]);
});


//Rotas protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/store/fornecedor', [FornecedorController::class, 'store']);
    Route::post('/alter/fornecedor', [FornecedorController::class, 'alter']);
    Route::post('/delete/fornecedor', [FornecedorController::class, 'delete']);
    Route::get('/fornecedores', [FornecedorController::class, 'getAllFornecedores']);
    
    Route::post('/store/produto', [ProdutoController::class, 'store']);
    Route::post('/alter/produto', [ProdutoController::class, 'alter']);
    Route::post('/delete/produto', [ProdutoController::class, 'delete']);
});

//Fornecedor
Route::get('/get-fornecedor', [FornecedorController::class, 'getFornecedor']);
Route::get('/dados-fornecedor', [FornecedorController::class, 'getDadosFornecedor']);




//Produto
Route::get('/pesquisar-produtos', [ProdutoController::class, 'buscarProdutos']);
Route::get('/produtos', [ProdutoController::class, 'getProdutos']);
Route::get('/dados-produto', [ProdutoController::class, 'getDadosProduto']);
Route::get('/filtro', [ProdutoController::class, 'buscarProdutosFiltro']);

