<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCourse extends Model
{
    use HasFactory;
    protected $table='users_courses';
    protected $fillable=[
        'user_id',
        'course_id',
        'progress',
        'complete'
    ];
}
