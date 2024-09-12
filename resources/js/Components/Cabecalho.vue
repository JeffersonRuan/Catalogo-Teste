<script setup>
import { ref } from 'vue';
import axios from 'axios';
    
    defineOptions({
        name: 'Cabecalho'
    });

    const pesquisaProdutos = ref([]); 
    const pesquisa = ref('');  

    async function listarProdutos(){
        try{
            const response = await axios.get('/api/pesquisar-produtos', {
                params: { nome: pesquisa.value }
            });

            

            pesquisaProdutos.value = response.data;
        } catch (error) {
            alert('Erro ao pesquisar!');
        }
    }

</script>

<template>
    <div class="cabecalho">
        <h1 class="titulo">Catálogo</h1>
        <div class="paginas">
            <a href="/" class="opcoes">Home</a>
            <a href="/produtos" class="opcoes">Produtos</a>
            <a href="/fornecedores" class="opcoes">Fornecedores</a>
        </div>
    </div>
</template>

