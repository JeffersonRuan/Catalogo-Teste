Catalógo Virtual - Novo Mundo

Este projeto foi desenvolvido para servir de avaliação ao teste para Desenvolvedor Junior da Novo Mundo, utilizando Laravel 11, Laravel Breeze com Vue.js 3 para o frontend e o Laravel Sanctum para a autenticação utilizando o tipo SPA. O banco de dados utilizado foi o SQLite, integrado diretamente na aplicação.

Pré-requisitos

Para rodar o projeto, é necessário ter os seguintes itens instalados em seu ambiente de desenvolvimento:

1. PHP 8.2 
2. Composer (Gerador de dependências do PHP)
3. Noje.js 18.x ou superior e NPM (Gerenciador de pacotes do JavaScript)
4. SQLite (integrado ao projeto)
5. Git 

Instalação

1. Clone o Repositório

No terminal bash, utilize o comando: git clone https://github.com//JeffersonRuan/Catalogo-Teste.git

Depois entre no diretório: cd Catalogo-Teste

2. Instale as Dependências do Backend PHP

Dentro do diretório do projeto, instale as dependências do Laravel: composer install

3. Instale as Dependências do Frontend

Dentro do diretório do projeto, instale as dependências do frontend utilizando o NPM: npm install 

4. Configuração do Arquivo .env

Crie uma cópia do arquivo de configuração .env.example e renomeie para .env

Gere a chave da aplicação Laravel: php artisan key:generate

5. Migração do Bando de Dados

Crie o arquivo database.sqlite dentro da pasta database

Execute as migrações para criar as tabelas no banco de dados: php artisan migrate

6. Inicie o Servidor de Desenvolvimento

Para iniciar o servidor do Laravel, execute o comando: php artisan serve

O servidor do backend estará disponível em: http://localhost:8000

7. Iniciar o Servidor do Frontend

Para compilar o FrontEnd da aplicação, execute o comando: npm run dev

8. Acessar a aplicação

Apos iniciado os servidores, a aplicação estará disponível em http://localhost:8000

9. Autenticação de Usuário

Este projeto utiliza o Laravel Sanctum para autenticação de SPA. O elemento "Login" da página levará direto para a página de autenticação.

Você também pode acessar as rotas de autenticação padrões que são:

http://localhost:8000/login
http://localhost:8000/register


Construido com

Laravel 11
Vue.js 3
Laravel Breeze com Vue
Laravel Sanctum (autenticação para SPA)
SQLite (banco de dados)


Expressões de gratidão

Esse projeto surgiu como uma oportunidade para avaliar meus conhecimentos técnicos e capacidade de entregar um solução funcional e de qualidade. Tive um grande aprendizado vendo na prática como o departamento de desenvolvimento atua, conhecendo as ferramentas e o ambiente, além de conhecer pessoas incríveis que trabalham na área.

Agradeço imensamente a oportunidade e espero ter entregue as espectativas!

por Jefferson Ruan.










