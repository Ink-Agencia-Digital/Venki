<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Description extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'profile_id'];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
