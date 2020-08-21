<?php

namespace App;

use App\Notifications\UserRegistration;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, SoftDeletes, HasRoles, MustVerifyEmail;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'lastname',
        'password',
        'birthday',
        'phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /** Mutators */

    public function setPasswordAttribute($value)
    {
        $this->attributes["password"] = Hash::make($value);
    }


    /** Relationships */

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'users_courses')->withPivot(['progress', 'complete']);
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class, 'receiver_id')->orWhere('chats.transmitter_id', $this->id);
    }

    public function linkedSocialAccounts()
    {
        return $this->hasMany(LinkedSocialAccount::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /** Overrided Functions */


    public function sendEmailVerificationNotification()
    {
        $this->notify(new UserRegistration);
    }
}
