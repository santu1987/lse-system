<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SublemaAcepcion;

class Sublema extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'lse_sublemas_entradas';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'id_entrada',
        'sublema',
    ];

    // Si tu tabla no usa timestamps (created_at, updated_at)
    public $timestamps = false;

    // Relación: un sublema pertenece a una entrada
    public function entrada()
    {
        return $this->belongsTo(EntradaLE::class, 'id_entrada');
    }

    // Relación: un sublema tiene muchas acepciones
    public function acepciones()
    {
        return $this->hasMany(SublemaAcepcion::class, 'id_sublema');
    }

}