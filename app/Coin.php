<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coin extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "magin",
        "user_id"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
