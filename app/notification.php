<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notification extends Model
{
    protected $table='notifications';
    protected $fillable=[
        'titulo',
        'mensaje'

    ];
}
