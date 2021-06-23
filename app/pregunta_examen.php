<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pregunta_examen extends Model
{
    protected $table='preguntas_examen';
    protected $fillable = [
        'id_examen',
        'pregunta',
        'tiporespuesta',
        'opciones',
        'valor'
    ];

    public function examen(){
        return $this->belongsTo(examen::class);
    }
    
    
}
