<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class membresia extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id',
        'nombre',
        'imagen',
        'precio',
        'duracion'
    ];

    public function pagos(){
        return $this->hasMany(pago::class,'membresia_id');
    }
}
