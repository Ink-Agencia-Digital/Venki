<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable = [
        'lesson_id',
        'type_resource_id',
        'audio',
        'video',
        'document'
    ];
}
