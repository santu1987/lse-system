<?php

namespace App\Models;

use App\Models\EntradaLE;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SublemaAcepcion extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'lse_sublemas_entradas_lengua_espanola';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'acepcion',
        'ejemplo',
        'id_categoria',
        'fecha_modificacion',
        'definicion_propia',
        'id_entrada',
        'id_sublema',
    ];

    // Si tu tabla no tiene created_at y updated_at
    public $timestamps = false;

    // Relación: cada acepción pertenece a un sublema
    public function sublema()
    {
        return $this->belongsTo(Sublema::class, 'id_sublema');
    }

    // Relación con Categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }
}