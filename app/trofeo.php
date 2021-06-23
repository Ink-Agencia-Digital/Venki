<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trofeo extends Model
{
    protected $table = ('trofeos');
    protected $fillable=[
        'rangoini',
        'rangofin',
        'nombre',
        'imagen'
    ];
}
