<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class examen extends Model
{
    protected $table='examenes';
    protected $fillable = [
        'id_course',
        'descripcion'
    ];

    public function courses(){
        return $this->belongsTo(Course::class);
    }

    public function preguntas(){
        return $this->hasMany(pregunta_examen::class,'id_examen');
    }

    public function respuestas_examen()
    {
        return $this->hasMany(respuesta_examen::class,'id_examen');
    }

    public function resultados_examen()
    {
        return $this->hasMany(resultado_examen::class,'id_examen');
    }
}
