<?php

namespace App\Http\Controllers\Course;

use App\Course;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Http\Resources\CourseResource;
use Illuminate\Http\Request;

class CourseController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->collectionResponse(CourseResource::collection($this->getModel(new Course, ['categories'])));
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
    public function store(StoreCourseRequest $request)
    {
        $course = new Course;
        $course->fill($request->all());

        if ($request->hasFile('photo')) {
            $course->photo = $request->photo->store('courses');
        }
        if ($request->hasFile('trailer')) {
            $course->trailer = $request->trailer->store('courses');
        }

        $course->saveOrFail();

        if ($request->has('categories')) {
            $course->categories()->attach($request->categories);
        }

        return $this->api_success([
            'data' => new CourseResource($course),
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        if ($request->has("name")) {
            $course->name = $request->name;
        }
        if ($request->has("description")) {
            $course->description = $request->description;
        }
        if ($request->has("trailer")) {
            $course->trailer = $request->trailer;
        }
        if ($request->has('categories')) {
            $course->categories()->detach();
            $course->categories()->attach($request->categories);
        }

        if (!$course->isDirty() && !$request->has('categories')) {
            return $this->errorResponse(
                'Se debe especificar al menos un valor diferente para actualizar',
                422
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return $this->singleResponse(new CourseResource($course), 200);
    }
}
