<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class roles extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'guard_name',
        'opcmenu'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
