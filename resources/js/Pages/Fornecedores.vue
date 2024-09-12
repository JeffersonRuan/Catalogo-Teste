<script setup>
import axios from 'axios';
import { onMounted, ref, watch } from 'vue';
import { Head } from '@inertiajs/vue3';
import Cabecalho from '../Components/Cabecalho.vue';

    components: {
        Cabecalho
    }

//Variáveis

    const codigoFornecedor = ref('');
    const nomeFornecedor = ref('');
    const fornecedores = ref([]);
    const ativarAddFornecedor = ref(false);
    const ativarAlterFornecedor = ref(false);
    const ativarDeleteFornecedor = ref(false);
    const ativarListaFornecedor = ref(false);
    const token = localStorage.getItem('authToken');

//Funções

//Salvar fornecedor
    async function salvarFornecedor(){
        try{
            const response = await axios.post('/api/salvar-fornecedor', {
                codigo: codigoFornecedor.value,
                nome: nomeFornecedor.value,
            });

            if(response.data.sucess){
                alert(response.data.message);
            } else {
                alert(response.data.message);
            }

        } catch (error){
            alert('Erro ao salvar o fornecedor!', error);
        }
    }

//Alterar fornecedor
    async function alterarFornecedor(){
        try{
            const response = await axios.post('/api/alterar-fornecedor', {
                codigo: codigoFornecedor.value,
                nome: nomeFornecedor.value
            });

            if(response.data.sucess){
                alert(response.data.message);
            } else {
                alert(response.data.message);
            }

        } catch (error){
            alert('Erro ao alterar o fornecedor!');
        }
    }

//Deletar fornecedor
    async function deletarFornecedor(){

        const confirmar = window.confirm(
            "Tem certeza que deseja deletar esse fornecedor ? Todos os produtos vinculados a esse fornecedor também serão deletados!"
        );

        if(!confirmar){
            return;
        }

        try{
            const response = await axios.post('/api/deletar-fornecedor', {
                codigo: codigoFornecedor.value
            });

            if(response.data.sucess){
                alert(response.data.message);
            } else {
                alert(response.data.message);
            }
        } catch (error){
            alert('Erro ao deletar o fornecedor!');
        }
    }

//Listar fornecedores
    async function listarFornecedores(){
        try{
            const response = await axios.get('/api/fornecedores');
            fornecedores.value = response.data;
        } catch (error){
            alert('Erro ao buscar a lista de fornecedores!');
        }
    }

//Buscar dados dos fornecedores
    async function buscarFornecedor(codigo){
            try{
                const response = await axios.get('/api/dados-fornecedor', {
                    params: { codigo: codigo }});
                
                console.log(response.data);

                    if(response.data){
                        nomeFornecedor.value = response.data.nome;
                    } else {
                        nomeFornecedor.value = "";
                    }

            } catch (error){
                console.log('Dando erro')
            }
    }

// Monitora alterações no código do fornecedor
    watch(codigoFornecedor, (newCodigo) => {
            if (newCodigo) {
                buscarFornecedor(newCodigo);
            }
        });


    const toggleAdd = () => {
        ativarAddFornecedor.value = !ativarAddFornecedor.value;
        ativarAlterFornecedor.value = false;
        ativarDeleteFornecedor.value = false;
    }

    const toggleAlter = () => {
        ativarAlterFornecedor.value = !ativarAlterFornecedor.value;
        ativarAddFornecedor.value = false;
        ativarDeleteFornecedor.value = false;
    }

    const toggleDelete = () => {
        ativarDeleteFornecedor.value = !ativarDeleteFornecedor.value;
        ativarAddFornecedor.value = false;
        ativarAlterFornecedor.value = false;
    }

    const toggleLista = () => {
        ativarListaFornecedor.value = !ativarListaFornecedor.value;
        listarFornecedores();
    }

</script>

<template>
    <Head title="Fornecedores" />
    <Cabecalho />

<!-- formulario para salvar um novo fornecedor -->
    <section class="formulario">

        <div class="form-container">
        <section class="header" @click="toggleAdd">
            <h2 class="titulo-formulario">Adicionar Fornecedor</h2>
        </section>

        <form v-if="ativarAddFornecedor" id="form" class="form" @submit.prevent="salvarFornecedor">
            <div class="form-content">
                <label for="id-produto">Codigo do Fornecedor</label>
                <input 
                type="number" 
                id="codigo"
                name="codigo" 
                placeholder="Código" 
                required
                v-model="codigoFornecedor">
                <a>Aqui vai a mensagem de erro...</a>
            </div>

            <div class="form-content">
                <label for="id-produto">Nome do Fornecedor</label>
                <input 
                type="text" 
                id="nome"
                name="nome" 
                placeholder="Digite o nome do fornecedor" 
                required
                v-model="nomeFornecedor">
                <a>Aqui vai a mensagem de erro...</a>
            </div>

            <button type="submit">Salvar</button>
        </form>
        </div>
    </section>    

<!-- formulario para alter um fornecedor existente -->
    <section class="formulario">
        <div class="form-container">
            <section class="header" @click="toggleAlter">
                <h2 class="titulo-formulario">Alterar Fornecedor</h2>
            </section>

            <form v-if="ativarAlterFornecedor" id="form" class="form" @submit.prevent="alterarFornecedor">
                <div class="form-content">
                    <label for="id-produto">Codigo do Fornecedor</label>
                    <input 
                    type="number" 
                    id="codigo"
                    name="codigo" 
                    placeholder="Código" 
                    required
                    v-model="codigoFornecedor">
                    <a>Aqui vai a mensagem de erro...</a>
                </div>

                <div class="form-content">
                    <label for="id-produto">Nome do Fornecedor</label>
                    <input 
                    type="text" 
                    id="nome"
                    name="nome" 
                    placeholder="Novo nome" 
                    required
                    v-model="nomeFornecedor">
                    <a>Aqui vai a mensagem de erro...</a>
                </div>

                <button type="submit">Alterar</button>
            </form>
        </div>
    </section>    

<!-- formulario para deletar um fornecedor existente -->
    <section class="formulario">
        <div class="form-container">
            <section class="header" @click="toggleDelete">
                <h2 class="titulo-formulario">Deletar Fornecedor</h2>
            </section>

            <form v-if="ativarDeleteFornecedor" id="form" class="form" @submit.prevent="deletarFornecedor">
                <div class="form-content">
                    <label for="id-produto">Codigo do Fornecedor</label>
                    <input 
                    type="number" 
                    id="codigo"
                    name="codigo" 
                    placeholder="Código" 
                    required
                    v-model="codigoFornecedor">
                    <a>Aqui vai a mensagem de erro...</a>
                </div>

                <div class="form-content">
                    <label for="id-produto">Nome do Fornecedor</label>
                    <input 
                    type="text" 
                    id="nome"
                    name="nome" 
                    v-model="nomeFornecedor"
                    >
                    <a>Aqui vai a mensagem de erro...</a>
                </div>

                <button type="submit">Deletar</button>
            </form>
        </div>
    </section>    

<!-- Botao para listar os fornecedores     -->
    <section class="lista-fornecedores">
        <div class="form-container">
            <section class="header" @click="toggleLista">
                <h2 class="titulo-formulario">Listar Fornecedores</h2>
            </section>

            <div v-if="ativarListaFornecedor && fornecedores.length > 0">
                <div class="colunas">
                    <p class="info-colunas">Codigo</p>
                    <p class="info-colunas">Nome</p>
                </div>
                <div class="card colunas" v-for="fornecedor in fornecedores" :key="fornecedor.codigo">
                    <p>{{ fornecedor.codigo }}</p>
                    <p class="card-nome">{{ fornecedor.nome }}</p>
                </div>

            </div>
        </div>
    </section>

</template>    

<style scoped>
    .lista-fornecedores {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
    }

    .colunas {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        padding: 15px;
    }

    .info-colunas {
        font-weight: bolder;
    }

    .card {
        border-top: 1px solid #EEEEEE;
        padding: 15px;
    }

</style>