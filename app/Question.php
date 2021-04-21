<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['question', 'survey_id', 'category_id', 'subcategory_id'];

    /**  Relationships */

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
}
