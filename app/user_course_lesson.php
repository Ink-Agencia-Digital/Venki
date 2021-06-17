<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_course_lesson extends Model
{
    use HasFactory;
    protected $table='users_courses_lessons';
    protected $fillable=[
        'id_user',
        'id_course',
        'id_lesson',
        'estado'
    ];

    public  function user()
    {
        return $this->hasOne(User::class);
    }

    public function course()
    {
        return $this->hasOne(Course::class);
    }

    public function lesson()
    {
        return $this->hasOne(Lesson::class);
    }

    

}
