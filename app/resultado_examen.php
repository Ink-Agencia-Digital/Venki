<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class resultado_examen extends Model
{
    protected $table = 'resultados_examen';
    protected $fillable=[
        'id_user',
        'id_examen',
        'id_trofeo',
        'nota'
    ];

    public function users()
    {
        return $this->belongsTo(Users::class);
    }

    public function examenes()
    {
        return $this->belongsTo(examenes::class);
    }

    public function trofeos()
    {
        return $this->belongsTo(trofeo::class);
    }
}
