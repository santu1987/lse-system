<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntradaLE extends Model
{
    // Nombre real de la tabla
    protected $table = 'lse_entradas_lengua_espanola';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'date_time',
        'entrada',
        'num_acepciones',
        'orden',
        'fecha_guardado',
        'num_sublemas',
    ];

    // Si tu tabla no usa created_at / updated_at
    public $timestamps = false;
}
