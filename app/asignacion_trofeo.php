<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class asignacion_trofeo extends Model
{
    protected $table='asignacion_trofeos';
    protected $fillable = [
        'id_user',
        'id_trofeo'
    ];

    public function Users()
    {
        return $this->belongsTo(User::class);
    }
    public function trofeos()
    {
        return $this->belongsTo(trofeo::class);
    }
}
