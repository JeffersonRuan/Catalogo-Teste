<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->integer('codigo')->primary();
            $table->string('nome');
        });

        Schema::create('produtos', function (Blueprint $table) {
            $table->integer('codigo')->primary();
            $table->string('nome');
            $table->string('descricao');
            $table->decimal('preco', 8, 2);
            $table->integer('codigo_fornecedor');
            $table->foreign('codigo_fornecedor')->references('codigo')->on('fornecedores')
            ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
