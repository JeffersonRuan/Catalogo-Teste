<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    use HasFactory;

    protected $table = 'fornecedores';
    protected $primaryKey = 'codigo';
    public $incrementing = false;
    protected $fillable = ['codigo', 'nome'];

    public $timestamps = false;
}
