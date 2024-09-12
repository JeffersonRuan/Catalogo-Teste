<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fornecedor;

class FornecedorController extends Controller
{

//Salvar fornecedor no banco de dados
    public function salvarFornecedor(Request $request){
    
        $fornecedor = new Fornecedor;

        if(!Fornecedor::find($request->codigo)){
            $fornecedor->codigo = $request->codigo;
            $fornecedor->nome = $request->nome;
            $fornecedor->save();

            return response()->json(['success' => true, 'message' => 'Fornecedor salvo com sucesso!']);

        } else{
            return response()->json(['success' => false, 'message' => 'Código do fornecedor já exisite no banco de dados!']);
        }
    }

//Alterar nome do fornecedor no banco
    public function alterarNomeFornecedor(Request $request){

        $fornecedor = Fornecedor::find($request->codigo);
        
        if($fornecedor){
            $fornecedor->nome = $request->nome;
            $fornecedor->save();

            return response()->json(['success' => true, 'message' => 'Fornecedor alterado!']);

        } else {
            return response()->json(['success' => false, 'message' => 'O código informado não existe!']);
        }
    }

//Deletar fornecedor no banco    
    public function deletarFornecedor(Request $request){

        $fornecedor = Fornecedor::find($request->codigo);

        if($fornecedor){
            $fornecedor->delete();

            return response()->json(['success' => true, 'message' => 'Fornecedor deletado com sucesso!']);

        } else {
            return response()->json(['success' => false, 'message' => 'O código informado não existe!']);
        }
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
