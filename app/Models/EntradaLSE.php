<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntradaLSE extends Model
{
    // Nombre real de la tabla
    protected $table = 'lse_entradas_lse';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'date_time',
        'id_entrada_le',
        'glosario',
        'nombres_propios',
        'foto',
        'video',
        'num_acepciones',
        'orden',
        'tiene_foto',
        'tiene_video',
        'tiene_acepcion',
        'tiene_ejemplo',
        'fecha_guardado',
        'oculto_en_web_diccionario_lse',
        'medida_imagen',
        'entrada_masculino',
        'entrada_femenino',
    ];

    // Si tu tabla no usa created_at / updated_at
    public $timestamps = false;

    // Relación con EntradaLE
    public function entradaLE()
    {
        return $this->belongsTo(EntradaLE::class, 'id_entrada_le');
    }
}