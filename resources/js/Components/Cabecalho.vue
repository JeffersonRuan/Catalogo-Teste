<script setup>
import { ref, computed } from 'vue';
import axios from 'axios';
    
    defineOptions({
        name: 'Cabecalho'
    });

    const pesquisaProdutos = ref([]); 
    const pesquisa = ref('');  
    const estaAutenticado = ref(false);

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

    //Login / Logout

    axios.get('api/auth/check').then(response => {
        estaAutenticado.value = response.data.authenticated;
    });

    const authText = computed(() => estaAutenticado.value ? 'Logout' : 'Login');
    
    const authAction = () => {
        if(estaAutenticado.value){
            axios.post('/api/logout').then(() => {
                estaAutenticado.value = false;
                alert('Logout realizado!');
            });
        } else {
            window.location.href = '/login';
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

        <div @click="authAction" class="opcoes auth">
            <i class="fa-solid fa-user"></i>
            <a>{{ authText }}</a>
        </div>

    </div>
</template>

