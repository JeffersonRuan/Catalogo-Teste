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
    Route::post('/salvar-fornecedor', [FornecedorController::class, 'salvarFornecedor']);
    Route::post('/alterar-fornecedor', [FornecedorController::class, 'alterarNomeFornecedor']);
    Route::post('/deletar-fornecedor', [FornecedorController::class, 'deletarFornecedor']);
    Route::get('/fornecedores', [FornecedorController::class, 'getAllFornecedores']);
    
    Route::post('/salvar-produto', [ProdutoController::class, 'salvarProduto']);
    Route::post('/alterar-produto', [ProdutoController::class, 'alterarProduto']);
    Route::post('/deletar-produto', [ProdutoController::class, 'deletarProduto']);
});

//Fornecedor
Route::get('/get-fornecedor', [FornecedorController::class, 'getFornecedor']);
Route::get('/dados-fornecedor', [FornecedorController::class, 'getDadosFornecedor']);

//Produto
Route::get('/pesquisar-produtos', [ProdutoController::class, 'buscarProdutos']);
Route::get('/produtos', [ProdutoController::class, 'getProdutos']);
Route::get('/dados-produto', [ProdutoController::class, 'getDadosProduto']);
Route::get('/filtro', [ProdutoController::class, 'buscarProdutosFiltro']);