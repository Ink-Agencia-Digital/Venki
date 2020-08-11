<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "transmitter_id",
        "receiver_id"
    ];

    /** Relationshiots */

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function reciever()
    {
        return $this->belongsTo(User::class, 'reciever_id');
    }

    public function transmitter()
    {
        return $this->belongsTo(User::class, 'transmitter_id');
    }
}
