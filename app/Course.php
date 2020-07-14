<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{

    use SoftDeletes;

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
