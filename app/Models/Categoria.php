<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SublemaAcepcion;

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

    // Relación inversa: una categoría tiene muchas acepciones
    public function acepciones()
    {
        return $this->hasMany(Acepciones::class, 'id_categoria');
    }

    // Relación inversa: una categoría tiene muchas SublemaAcepciones
    public function sublemasAcepciones()
    {
        return $this->hasMany(SublemaAcepcion::class, 'id_categoria');
    }

}