<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Fornecedor;


class ProdutoController extends Controller
{

//Criar um novo produto na tabela
    public function store(Request $request){

        $validated = $request->validate([
            'codigo' => 'required|integer|unique:produtos,codigo',
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'codigo_fornecedor' => 'required|exists:fornecedores,codigo',
        ],[
            'codigo.required' => 'O campo código é obrigatório',
            'codigo.unique' => 'O código já foi utilizado por outro produto',
            'codigo_fornecedor.required' => 'O campo código do fornecedor é obrigatório',
            'codigo_fornecedor.exists' => 'O fornecedor selecionado é inválido ou não existe no sistema'
        ]);

        $produto = new Produto;
        $produto->codigo = $validated['codigo'];
        $produto->nome = $validated['nome'];
        $produto->descricao = $validated['descricao'];
        $produto->preco = $validated['preco'];
        $produto->codigo_fornecedor = $validated['codigo_fornecedor'];
        $produto->save();

        return response()->json([
            'success' => true,
            'message' => 'Produto salvo com sucesso!'
        ]);
    }
    
//Alterar Produto
    public function alter(Request $request){

        $validated = $request->validate([
            'codigo' => 'required|exists:produtos,codigo',
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
        ], [
            'codigo.exists' => 'O produto selecionado é inválido ou não existe no sistema'
        ]);

        $produto = Produto::find($validated['codigo']);
        $produto->nome = $validated['nome'];
        $produto->descricao = $validated['descricao'];
        $produto->preco = $validated['preco'];
        $produto->save();

        return response()->json([
            'success' => true,
            'message' => 'Produto alterado!'
        ]);
    }

//Deletar Produto
    public function delete(Request $request) {

        $validated = $request->validate([
            'codigo' => 'required|exists:produtos,codigo'
        ],[
            'codigo.exists' => 'O produto selecionado é inválido ou não existe no sistema'
        ]);

        $produto = Produto::find($validated['codigo']);
        $produto->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produto deletado'
        ]);
    }

//Buscar produtos por codigo ou nome
    public function buscarProdutos(Request $request){
        
        $termo = $request->query('termo');

        $query = Produto::query();

        if(!is_null($termo) && trim($termo) !== ''){
            if(is_numeric($termo)){
                $query->where('codigo', $termo);
            } else{
                $query->where('nome', 'like', '%' . $termo . '%');
            }
        }

        $produtos = $query->get();

        if($produtos->isNotEmpty()){
            return response()->json($produtos);
        } else {
            return response()->json(['success' => false, 'message' => 'Produto não encontrado!']);
        }
    }

//Buscar todos os produto
    public function getProdutos(){

        $produtos = Produto::all();
        return response()->json($produtos);
    }

//Buscar informações do produto
    public function getDadosProduto(Request $request){

        $produto = Produto::where('codigo', $request->codigo)->first();

        if($produto){
            return response()->json($produto);
        } else {
            return response()->json(['sucess' => false, 'message' => 'Nenhum produto encontrado!']);
        }
    }    

//Filtro 
    public function buscarProdutosFiltro(Request $request){
        $preco_min = $request->query('preco_min'); 
        $preco_max = $request->query('preco_max');
        $codigo_fornecedor = $request->query('codigo_fornecedor');

        $query = Produto::query();

        if (!is_null($preco_min)) {
            $query->where('preco', '>=', $preco_min);
        }

        if (!is_null($preco_max)) {
            $query->where('preco', '<=', $preco_max);
        }

        if (!is_null($codigo_fornecedor)) {
            $query->where('codigo_fornecedor', $codigo_fornecedor);
        }

        $produtos = $query->get();

        if ($produtos->isNotEmpty()) {
            return response()->json($produtos);
        } else {
            return response()->json(['success' => false, 'message' => 'Nenhum produto encontrado!']);
        }
    }  
}


