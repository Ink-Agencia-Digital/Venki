<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name',
        'description',
        'trailer',
    ];

    /** RELATIONSHIPS */

    public function categories()
    {
        return $this->belongsToMany(Course::class, 'courses_categories');
    }
}
