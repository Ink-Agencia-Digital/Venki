<?php

namespace App\Http\Controllers\User;

use App\Course;
use App\Http\Controllers\Api\ApiController;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Http\Resources\UserResource;
use App\User;
use App\Coin;
use Illuminate\Http\Request;

class UserCourseController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $courses = $user->courses()->with(['lessons.resources'=>function($query){
            return $query->orderBy('resources.order');
        }]);

        return $this->collectionResponse(CourseResource::collection($this->getModel(new Course, ['lessons.exam'], $courses)));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $course = Course::findOrFail($request->course_id);
        $user->courses()->attach($course);
        $coin = Coin::where('user_id','=',$user->id)->get();
        //se asignan 50 coins al registrarse en un curso.
        if(($coin->count()>0) && ($coin[0]->user_id==$user->id))
        {
            $magins=$coin[0]->magin+50;
            Coin::where('user_id','=',$user->id)->update(['magin'=>$magins,'updated_at'=>Carbon::now()]);
        }
        else
        {
            Coin::insert(['user_id'=>$user->id,'magin'=>50,'created_at'=>Carbon::now()]);
        }
        return $this->api_success([
            'data' => [
                "user" => new UserResource($user),
                "course" => new CourseResource($course)
            ],
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, Course $course)
    {
        if ($request->has('complete')) {
            $user->courses()->sync([$course->id => ['complete' => $request->complete]]);
        }
        if ($request->has('progress')) {
            $user->courses()->sync([$course->id => ['progress' => $request->progress]]);
        }
        $user->with(['courses' => function ($query) use ($course) {
            return $query->where('courses.id', $course->id);
        }])->first();

        return $this->api_success([
            'data'      =>  new UserResource($user),
            'message'   => __('pages.responses.updated'),
            'code'      =>  201
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Course $course)
    {
        $user->courses()->detach($course);

        return $this->api_success([
            'data' => [
                "user" => new UserResource($user),
                "course" => new CourseResource($course)
            ],
            'message'   => __('pages.responses.deleted'),
            'code'      =>  200
        ], 200);
    }
}
