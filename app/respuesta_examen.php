<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class respuesta_examen extends Model
{
    protected $table = 'respuestas_examen';
    protected $fillable=[
        'id_user',
        'id_examen',
        'pregunta',
        'respuesta',
        'valor',
        'correcto'
    ];

    public function Users()
    {
        return $this->belongsTo(User::class);
    }

    public function Examenes()
    {
        return $this->belongsTo(examen::class);
    }
}
