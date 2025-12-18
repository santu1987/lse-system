<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acepciones extends Model
{
    use HasFactory;

    // Nombre de la tabla (si no sigue la convención plural)
    protected $table = 'lse_acepciones_entradas_lengua_espanola';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'acepcion',
        'ejemplo',
        'id_categoria',
        'fecha_modificacion',
        'definicion_propia',
        'id_entrada',
    ];

    // Si quieres que Laravel maneje automáticamente created_at y updated_at
    public $timestamps = false;

    // Relación con Categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    // Relación con Entrada
    public function entrada()
    {
        return $this->belongsTo(EntradaLE::class, 'id_entrada');
    }
}