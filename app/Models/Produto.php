<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'produtos';
    protected $primaryKey = 'codigo';
    public $incrementing = false;
    protected $fillable = ['codigo', 'nome', 'descricao','preco','codigo_fornecedor'];

    public $timestamps = false;
}
