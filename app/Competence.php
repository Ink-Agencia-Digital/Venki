<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Competence extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'comment',
        'type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function medias()
    {
        return $this->hasMany(CompetenceMedia::class);
    }
}
