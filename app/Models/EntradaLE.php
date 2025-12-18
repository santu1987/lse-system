<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EntradaLE extends Model
{
    use SoftDeletes;
    // Nombre real de la tabla
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

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
    
    // Relación inversa: una entrada tiene muchas acepciones
    public function acepciones()
    {
        return $this->hasMany(Acepciones::class, 'id_entrada');
    }

}
