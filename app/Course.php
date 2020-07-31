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
        return $this->belongsToMany(Category::class, 'courses_categories');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }
}
