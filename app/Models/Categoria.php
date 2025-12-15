<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    // Nombre real de la tabla (ajústalo si tu tabla se llama distinto)
    protected $table = 'lse_categorias';

    protected $fillable = [
        'date_time',
        'categoria',
        'entrada',
    ];

    // Si tu tabla no usa created_at / updated_at
    public $timestamps = false;
}