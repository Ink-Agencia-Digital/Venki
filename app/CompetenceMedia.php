<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetenceMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'competence_id',
        'media',
        'type'
    ];

    public function competence()
    {
        return $this->belongsTo(Competence::class);
    }
}
