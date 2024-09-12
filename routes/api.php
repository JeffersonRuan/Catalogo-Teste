<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\ProdutoController;
use App\Models\Token;


//Criar token de autenticação
Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        $token = Str::random(60);

        // Armazenar o token no banco de dados
        Token::create([
            'user_id' => $user->id,
            'token' => hash('sha256', $token)
        ]);

        return response()->json(['token' => $token], 200);
    }

    return response()->json(['message' => 'Credenciais inválidas!'], 401);
});


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('auth.token')->group(function () {
});

//Fornecedor
Route::post('/salvar-fornecedor', [FornecedorController::class, 'salvarFornecedor']);

Route::post('/alterar-fornecedor', [FornecedorController::class, 'alterarNomeFornecedor']);

Route::post('/deletar-fornecedor', [FornecedorController::class, 'deletarFornecedor']);

Route::get('/get-fornecedor', [FornecedorController::class, 'getFornecedor']);

Route::get('/fornecedores', [FornecedorController::class, 'getAllFornecedores']);

Route::get('/dados-fornecedor', [FornecedorController::class, 'getDadosFornecedor']);

//Produto
Route::post('/salvar-produto', [ProdutoController::class, 'salvarProduto']);

Route::post('/alterar-produto', [ProdutoController::class, 'alterarProduto']);

Route::post('/deletar-produto', [ProdutoController::class, 'deletarProduto']);

Route::get('/pesquisar-produtos', [ProdutoController::class, 'buscarProdutos']);

Route::get('/produtos', [ProdutoController::class, 'getProdutos']);

Route::get('/dados-produto', [ProdutoController::class, 'getDadosProduto']);

Route::get('/filtro', [ProdutoController::class, 'buscarProdutosFiltro']);