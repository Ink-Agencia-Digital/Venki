<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'name',
        'photo',
        'description',
        'category_id',
        'pdf',
        'video'
    ];

    /** Relationships */

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'courses_categories');
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function childrenCategories()
    {
        return $this->hasMany(Category::class)
            ->with('categories');
    }

}
