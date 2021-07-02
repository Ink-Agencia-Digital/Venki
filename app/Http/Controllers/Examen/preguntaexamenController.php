<?php

namespace App\Http\Controllers\Examen;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use App\pregunta_examen;
use App\Examen;
use App\Http\Resources\PreguntaExamenResource;
use App\Http\Requests\StorePreguntaExamenRequest;
use App\Http\Requests\UpdatePreguntaExamenRequest;

class preguntaexamenController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
    public function store(StorePreguntaExamenRequest $request)
    {
        $pregunta = new pregunta_examen;
        $pregunta->fill($request->all());
        $pregunta->saveOrFail();

        return $this->api_success([
            'data' => new PreguntaExamenResource($pregunta),
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\pregunta_examen  $pregunta
     * @return \Illuminate\Http\Response
     */
    public function show(pregunta_examen $pregunta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function edit(pregunta_examen $pregunta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\pregunta_examen  $pregunta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pregunta_examen $pregunta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy(pregunta_examen $pregunta)
    {
        $pregunta->delete();
        return $this->api_success([
            'data' => new PreguntaExamenResource($pregunta),
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }
}
