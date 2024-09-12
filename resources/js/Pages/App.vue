<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import Cabecalho from '../Components/Cabecalho.vue';

//Variáveis
    const produtos = ref([]);
    const pesquisaProdutos = ref([]);
    const pesquisaFornecedor = ref(''); 
    const produtosPorFiltro = ref([]);
    const precoMin = ref('');
    const precoMax = ref('');
    const pesquisa = ref('');  
    const listaAtiva = ref(true);
    const filtroAtivo = ref(false);

//Funções

//Listar produtos na home
    async function buscarProdutos(){
        try{
            const response = await axios.get('/api/produtos');
            produtos.value = response.data;
        } catch (error){
            console.log('Erro ao buscar produtos!');
        }
    }

    onMounted(() => {buscarProdutos()});

//Filtrar produtos 
    async function filtrarProdutos(){
        try{
            const response = await axios.get('/api/filtro', {
                params: {
                    preco_min: precoMin.value,
                    preco_max: precoMax.value,
                    codigo_fornecedor: pesquisaFornecedor.value
                }
            });

            produtosPorFiltro.value = response.data;
            listaAtiva.value = false;

        } catch (error){
            console.log(response.data.message);
        }
    }

//Pesquisar produtos por nome
    async function listarProdutos(){
        try{
            const response = await axios.get('/api/pesquisar-produtos', {
                params: { termo: pesquisa.value }
            });
            pesquisaProdutos.value = response.data;
            listaAtiva.value = false;
            console.log(pesquisaProdutos.value);
        } catch (error) {
            alert('Erro ao pesquisar!');
        }
    }

//Exibição dinâmica da página    
    const toggleFiltro = () => {
        filtroAtivo.value = !filtroAtivo.value;
    }

    const limparFiltro = () => {
        listaAtiva.value = true;
        precoMin.value = "";
        precoMax.value = "";
        pesquisaFornecedor.value = "";
        produtosPorFiltro.value = "";

    }
</script>

<template>
    <Head title="Catálogo" />
<!-- cabecalho -->
    <div class="cabecalho">
        <h1 class="titulo">Catálogo</h1>
        <div class="search">
            <input 
            class="barraPesquisa" type="text" 
            placeholder="Buscar Produto"
            v-model="pesquisa">
            <i class="fa fa-search" @click="listarProdutos"></i>
            <p class="toggle-filtro" @click="toggleFiltro">+ Adicionar filtro</p>
        </div>

        <div class="paginas">
            <a href="/" class="opcoes">Home</a>
            <a href="/produtos" class="opcoes">Produtos</a>
            <a href="/fornecedores" class="opcoes">Fornecedores</a>
        </div>
    </div>

<!-- body -->
    <section class="main">

<!-- seção de filtro ativo -->
        <div class="filtro" v-if="filtroAtivo">    
                <div class="filtro-conteudo">
                    <label for="codigo_fornecedor">Codigo Fornecedor</label>
                    <input 
                    type="text" 
                    id="codigo_fornecedor"
                    name="codigo_fornecedor"
                    placeholder="Código"
                    v-model="pesquisaFornecedor">
                </div>
                
                <div class="filtro-conteudo">
                    <label for="Preco">Preço</label>
                    <input 
                    type="text" 
                    id="preco_min"
                    name="preco_min"
                    placeholder="Min"
                    v-model="precoMin"
                    >
                    <input 
                    type="text" 
                    id="preco_max"
                    name="preco_max"
                    placeholder="Max"
                    v-model="precoMax"
                    >
                </div> 
                <button type="submit" @click="limparFiltro">Limpar Filtro</button>
                <button type="submit" @click="filtrarProdutos">Filtrar</button>
            </div>  

<!-- colunas da lista de produtos -->
        <div class="colunas">
            <p class="info-coluna">CÓDIGO</p>
            <p class="info-coluna">NOME</p>
            <p class="info-coluna">DESCRIÇÃO</p>
            <p class="info-coluna">PREÇO</p>
            <p class="info-coluna">FORNECEDOR</p>
        </div>

<!-- lista de produtos da pesquisa -->
        <div class="pesquisa">
            <div v-if="pesquisaProdutos.length > 0">
                <div class="card colunas" v-for="produto in pesquisaProdutos" :key="produto.codigo">
                    <p>{{ produto.codigo }}</p>
                    <p class="card-nome">{{ produto.nome }}</p>
                    <p class="card-descricao">{{ produto.descricao }}</p>
                    <p class="card-preco">R$ {{ produto.preco }}</p>
                    <p class="card-fornecedor">{{ produto.codigo_fornecedor }}</p>
                </div>
                <a href="/" class="pesquisa-voltar">Voltar</a>
            </div>
            <div v-else-if="pesquisaProdutos.success == false">
                <p class="pesquisa-mensagem">Produto não encontrado!</p>
                <a href="/" class="pesquisa-voltar">Voltar</a>
            </div>
        </div>

<!-- lista de produtos principal -->
        <div class="produtos" v-if="listaAtiva">
            <div class="card colunas" v-for="(produto, index) in produtos" :key="index">
                <p>{{ produto.codigo }}</p>
                <p class="card-nome">{{ produto.nome }}</p>
                <p class="card-descricao">{{ produto.descricao }}</p>
                <p class="card-preco">R$ {{ produto.preco }}</p>
                <p class="card-fornecedor">{{ produto.codigo_fornecedor }}</p>
            </div>
            
        </div>

<!-- lista de produtos por filtro -->
        <div>
            <div v-if="produtosPorFiltro.length > 0">
                <div class="card colunas" v-for="produto in produtosPorFiltro" :key="produto.codigo">
                    <p>{{ produto.codigo }}</p>
                    <p class="card-nome">{{ produto.nome }}</p>
                    <p class="card-descricao">{{ produto.descricao }}</p>
                    <p class="card-preco">R$ {{ produto.preco }}</p>
                    <p class="card-fornecedor">{{ produto.codigo_fornecedor }}</p>
                </div>
            </div>            
        </div>
    </section>

</template>

<style scoped>

.main {
    width: 70%;
    margin: auto auto;
}

/* Pesquisa */

.pesquisar {
    background-color: #000;
    padding: 5px 15px 5px 15px;
    border-radius: 20px;
    font-weight: bolder;
    color: #fff
}

.search {
    display: flex;
    align-items: center;
}

.search i {
    cursor: pointer;
    color: #fff;
    margin-right: 20px;
}

.pesquisa-mensagem {
    margin: 40px 0 40px 15px;
    font-size: 18px;
}

.pesquisa-voltar {
    margin-left: 15px;
}

.pesquisa-voltar:hover {
    text-decoration: underline;
    color: #04049E;
}

.colunas {
    display: grid;
    grid-template-columns: .2fr .5fr 1fr .4fr .3fr;
    gap: 10px;
    padding: 15px;
}

.info-coluna {
    font-weight: bolder;
}

.card {
    border-top: 1px solid #EEEEEE;
    padding: 15px;
}

/* filtro */

.toggle-filtro {
    background-color: #000;
    color: #fff;
    border-radius: 10px;
    padding: 8px;
    text-align: center;
    width: 150px;
    cursor: pointer;
}

.filtro {
    background-color: #EEEEEE;
    border-radius: 10px;
    padding: 20px;
    margin: 10px 0 10px 0;
    display: flex;
    justify-content: space-between;
}

.filtro-conteudo {
    display: flex;
    flex-direction: column;
}

.filtro-conteudo input {
    border-radius: 8px;
    padding: 5px;
    border: 2px solid #dfdfdf;
    width: 150px;
}

.filtro button {
    background-color: #040491;
    color: #fff;
    width: 30%;
    padding: 5px;
    border-radius: 8px;
    margin-top: 14px;
    align-self: center;
}

</style>