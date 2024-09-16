<script setup>
import axios from 'axios';
import { onMounted, ref, watch } from 'vue';
import { Head } from '@inertiajs/vue3';
import Cabecalho from '../Components/Cabecalho.vue';

    components: {
        Cabecalho
    }


//Variáveis
    const codigoProduto = ref('');
    const nomeProduto = ref('');
    const descricaoProduto = ref('');
    const precoProduto = ref('');
    const codigoFornecedor = ref('');
    const ativarAddProduto = ref(false); 
    const ativarAlterProduto = ref(false);
    const ativarDeleteProduto = ref(false);

//Funções

//Salvar um novo produto
    async function salvarProduto(){
        try{
                const response = await axios.post('/api/store/produto', {
                codigo: codigoProduto.value,
                nome: nomeProduto.value,
                descricao: descricaoProduto.value,
                preco: precoProduto.value,
                codigo_fornecedor: codigoFornecedor.value
            });

            if(response.data.success){
                alert(response.data.message);
            } 

        } catch (error){
            if(error.response && error.response.data.errors){
                let MensagemErro = '';
                for(let key in error.response.data.errors){
                    MensagemErro += error.response.data.errors[key].join(' ') + '\n';
                }
                alert(MensagemErro);
            } else {
                alert('Usuário não autenticado. Por favor, realize o login e tente novamente.');
            }
         }
    }

//Alterar um produto existente
    async function alterarProduto(){
        try{
            const response = await axios.post('/api/alter/produto', {
                codigo: codigoProduto.value,
                nome: nomeProduto.value,
                descricao: descricaoProduto.value,
                preco: precoProduto.value
            });

            if(response.data.success){
                alert(response.data.message);
            } 
        }catch (error){
            if(error.response && error.response.data.errors){
                let MensagemErro = '';
                for(let key in error.response.data.errors){
                    MensagemErro += error.response.data.errors[key].join(' ') + '\n';
                }
                alert(MensagemErro);
            } else {
                alert('Usuário não autenticado. Por favor, realize o login e tente novamente.');
            }
        }
    }


//Deletar um produto existente
    async function deletarProduto(){

        const confirmar = window.confirm(
            "Deltar produto?"
        );

        if(!confirmar){
            return;
        }

        try{
            const response = await axios.post('/api/delete/produto', {
                codigo: codigoProduto.value
            });

            if(response.data.success){
                alert(response.data.message);
            }

        } catch (error){
            if(error.response && error.response.data.errors){
                let MensagemErro = '';
                for(let key in error.response.data.errors){
                    MensagemErro += error.response.data.errors[key].join(' ') + '\n';
                }
                alert(MensagemErro);
            } else {
                alert('Usuário não autenticado. Por favor, realize o login e tente novamente.');
            }
        }
    }

//Buscar dados dos produtos
    async function buscarDadosProdutos(codigo){
        try{
            const response = await axios.get('/api/dados-produto', {
                params: { codigo: codigo }});

            if(response.data){
                nomeProduto.value = response.data.nome;
                descricaoProduto.value = response.data.descricao;
                precoProduto.value = response.data.preco;
            } else {
                nomeProduto.value = "";
                descricaoProduto.value = "";
                precoProduto.value = "";
            }   
            
        } catch (error){
            console.log('buscarDadosProduto não funcionou');
        }
    }

    watch(codigoProduto, (newCodigo) => {
        if(newCodigo){
            buscarDadosProdutos(newCodigo);
        }
    })



//Ativação de variáveis de estado
    const toggleAdd = () => {
        ativarAddProduto.value = !ativarAddProduto.value;
        ativarAlterProduto.value = false;
        ativarDeleteProduto.value = false;
    }

    const toggleAlter = () => {
        ativarAlterProduto.value = !ativarAlterProduto.value;
        ativarAddProduto.value = false;
        ativarDeleteProduto.value = false;
    }
    
    const toggleDelete = () => {
        ativarDeleteProduto.value = !ativarDeleteProduto.value;
        ativarAddProduto.value = false;
        ativarAlterProduto.value = false;
    }


</script>

<template>
    <Head title="Produtos" />
    <Cabecalho />

<!-- Formulario para adicionar um novo produto -->
    <section class="formulario">
        <div class="form-container">
            <section class="header" @click="toggleAdd">
                <h2 class="titulo-formulario">Adicionar Produto</h2>
            </section>

            <form v-if="ativarAddProduto" id="form" class="form" @submit.prevent="salvarProduto">
                <div class="form-content">
                    <label for="id-produto">Codigo do Produto</label>
                    <input 
                    type="number" 
                    id="codigo"
                    name="codigo" 
                    placeholder="Código" 
                    required
                    v-model="codigoProduto"
                    >
                    <a>Aqui vai a mensagem de erro...</a>
                </div>    

                <div class="form-content">
                    <label for="nome-produto">Nome do Produto</label>
                    <input 
                    type="text" 
                    id="nome" 
                    name="nome"
                    placeholder="Digite o nome do produto" 
                    required
                    v-model="nomeProduto">
                </div>

                <div class="form-content">
                    <label for="descricao-produto">Descrição</label>
                    <input 
                    type="text" 
                    id="descricao"
                    name="descricao" 
                    placeholder="Digite a descrição do produto" 
                    required
                    v-model="descricaoProduto">
                </div>

                <div class="form-content">
                    <label for="preco-produto">Preco</label>
                    <input 
                    type="number" 
                    step="0.01"
                    id="preco"
                    name="preco" 
                    placeholder="Digite o preço" 
                    required
                    v-model="precoProduto">
                </div>

                <div class="form-content">
                    <label for="codigo-fornecedor">Codigo do fornecedor</label>
                    <input 
                    type="number" 
                    id="codigo_fornecedor" 
                    name="codigo_fornecedor"
                    placeholder="Código" 
                    required
                    v-model="codigoFornecedor">
                </div>

                <button type="submit">Salvar</button>

            </form>
        </div>
    </section>

<!-- Formulario para alterar um produto existente -->
    <section class="formulario">

        <div class="form-container">
            <section class="header" @click="toggleAlter">
                <h2 class="titulo-formulario">Alterar Produto</h2>
           </section>

            <form v-if="ativarAlterProduto" id="form" class="form" @submit.prevent="alterarProduto">
                <div class="form-content">
                    <label for="id-produto">Código do Produto</label>
                    <input 
                        type="number" 
                        id="codigo"
                        name="codigo" 
                        placeholder="Código" 
                        required
                        v-model="codigoProduto">
                </div>    

                <div class="form-content">
                    <label for="nome-produto">Nome do Produto</label>
                    <input 
                        type="text" 
                        id="nome" 
                        name="nome"
                        placeholder="Novo nome" 
                        required
                        v-model="nomeProduto">
                </div>

                <div class="form-content">
                    <label for="descricao-produto">Descrição</label>
                    <input 
                        type="text" 
                        id="descricao"
                        name="descricao" 
                        placeholder="Nova descrição" 
                        required
                        v-model="descricaoProduto">
                </div>

                <div class="form-content">
                    <label for="preco-produto">Preco</label>
                    <input 
                        type="number"
                        step="0.01" 
                        id="preco"
                        name="preco" 
                        placeholder="Novo preço" 
                        required
                        v-model="precoProduto">
                </div>

                <button type="submit">Alterar</button>
            </form>
        </div>
    </section>        

<!-- Formulario para deletar um produto -->
    <section class="formulario">
        <div class="form-container">
            <section class="header" @click="toggleDelete">
                <h2 class="titulo-formulario">Deletar Produto</h2>
            </section>

            <form v-if="ativarDeleteProduto" id="form" class="form" @submit.prevent="deletarProduto">
                <div class="form-content">
                    <label for="id-produto">Codigo do Produto</label>
                    <input 
                        type="number" 
                        id="codigo"
                        name="codigo" 
                        placeholder="Código" 
                        required
                        v-model="codigoProduto">
                </div>    

                <div class="form-content">
                    <label for="nome-produto">Nome do Produto</label>
                    <input 
                        type="text" 
                        id="nome" 
                        name="nome"
                        v-model="nomeProduto" 
                        >
                </div>
                <button type="submit">Deletar</button>

            </form>    
        </div>    
    </section>    

</template>

<style scoped>
</style>