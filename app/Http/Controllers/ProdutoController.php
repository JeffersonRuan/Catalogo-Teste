<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Fornecedor;


class ProdutoController extends Controller
{
    
//Criar um novo produto na tabela
    public function salvarProduto(Request $request){

        $codigo = $request->codigo;
        $codigoFornecedor = $request->codigo_fornecedor;

        $produtoExistente = Produto::where('codigo', $codigo)->exists();

        $fornecedorExistente = Fornecedor::where('codigo', $codigoFornecedor)->exists();

        $produto = new Produto;

        if (!$produtoExistente && $fornecedorExistente) {
            
            $produto->codigo = $request->codigo;
            $produto->nome = $request->nome;
            $produto->descricao = $request->descricao;
            $produto->preco = $request->preco;
            $produto->codigo_fornecedor = $request->codigo_fornecedor;
            $produto->save();

            return response()->json(['success' => true, 'message' => 'Produto salvo com sucesso!']);

        } else {
            if ($produtoExistente) {
                return response()->json(['success' => false, 'message' => 'Código do produto já existe no banco de dados!']);

            } elseif (!$fornecedorExistente) {
                return response()->json(['success' => false, 'message' => 'Fornecedor não exisite no banco de dados!']);

            }
        }
    }


//Alterar Produto
    public function alterarProduto(Request $request){

        $produto = Produto::find($request->codigo);

        if($produto){
            $produto->nome = $request->nome;
            $produto->descricao = $request->descricao;
            $produto->preco = $request->preco;
            $produto->save();

            return response()->json(['success' => true, 'message' => 'Produto alterado!']);

        } else {
            return response()->json(['success' => false, 'message' => 'Código do produto não existe!']);
        }
    }

//Deletar Produto
    public function deletarProduto(Request $request){

        $produto = Produto::find($request->codigo);

        if($produto){
            $produto->delete();
            return response()->json(['success' => true, 'message' => 'Produto deletado!']);
        } else {
            return response()->json(['success' => false, 'message' => 'Código do produto não existe!']);
        }
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

        // $produtos = Produto::where('nome', 'like', '%' . $nome . '%')->get();
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


