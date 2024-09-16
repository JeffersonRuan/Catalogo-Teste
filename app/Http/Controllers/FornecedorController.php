<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fornecedor;

class FornecedorController extends Controller
{

//Salvar fornecedor no banco de dados
    public function store(Request $request) {

        $validated = $request->validate([
            'codigo' => 'required|integer|unique:fornecedores,codigo',
            'nome' => 'required|string|max:255'
        ], [
            'codigo.unique' => 'O código já foi utilizado por outro fornecedor'
        ]);

        $fornecedor = new Fornecedor;
        $fornecedor->codigo = $validated['codigo'];
        $fornecedor->nome = $validated['nome'];
        $fornecedor->save();

        return response()->json([
            'success' => true,
            'message' => 'Fornecedor salvo'
        ]);
    }

//Alterar nome do fornecedor no banco
    public function alter(Request $request) {

        $validated = $request->validate([
            'codigo' => 'required|exists:fornecedores,codigo',
            'nome' => 'required|string|max:255'
        ], [
            'codigo.exists' => 'O fornecedor selecionado é inválido ou não existe no sistema'
        ]);

        $fornecedor = Fornecedor::find($validated['codigo']);
        $fornecedor->nome = $validated['nome'];
        $fornecedor->save();

        return response()->json([
            'success' => true,
            'message' => 'Fornecedor alterado!'
        ]);
    }

//Deletar fornecedor no banco    
    public function delete(Request $request) {
        
        $validated = $request->validate([
            'codigo' => 'required|exists:fornecedores,codigo'
        ], [
            'codigo.exists' => 'O fornecedor selecionado é inválido ou não existe no sistema'
        ]);

        $fornecedor = Fornecedor::find($validated['codigo']);
        $fornecedor->delete();

        return response()->json([
            'success' => true,
            'message' => 'Fornecedor deletado'
        ]);

    }

//Buscar todos os fornecedores do banco
    public function getAllFornecedores(){
        
        $fornecedores = Fornecedor::all();
        return response()->json($fornecedores);
    }

//Buscar informações do fornecedor     
    public function getDadosFornecedor(Request $request){

        $fornecedor = Fornecedor::where('codigo', $request->codigo)->first();

        if($fornecedor){
            return response()->json($fornecedor);
        } else {
            return response()->json(['sucess' => false, 'message' => 'Fornecedor não encontrado']);
        }
    }
}
