<?php

namespace App\Http\Controllers\Examen;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\examen;
use App\Course;
use App\Http\Resources\examenResource;

class examenController extends ApiController
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($idcourse)
    {
        //$examen = $course->examen(1);
        //return $this->collectionResponse(examen::collection($this->getModel(new examen,[],$examen)));
        $examen = examen::where('id_course','=',$idcourse)->get();
        return response()->json([
            'data'=>$examen
        ]);
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
    public function store(Request $request)
    {
        $exam = new examen;
        $exam->fill($request->all());
        $exam->saveOrFail();

        return $this->api_success([
            'data' => new ExamenResource($exam),
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function show(examen $exam)
    {

    ///
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function edit(examen $exam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, examen $exam)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy(examen $exam)
    {
        $exam->delete();
        return $this->api_success([
            'data' => new ExamenResource($exam),
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }
}
