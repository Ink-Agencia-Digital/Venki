<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\respuesta_examen;
use App\Examen;
use App\Http\Resources\respuestaExamenResource;
use App\Http\Requests\StorerespuestaExamenRequest;
use App\Http\Requests\UpdaterespuestaExamenRequest;

class respuestaExamenController extends ApiController
{
    //
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
    public function store(StorerespuestaExamenRequest $request)
    {
        foreach($request->all() as $item)
        {
            $respuesta = new respuesta_examen();
            $respuesta->id_user=$item['id_user'];
            $respuesta->id_examen = $item['id_examen'];
            $respuesta->pregunta = $item['pregunta'];
            $respuesta->respuesta = $item['respuesta'];
            $respuesta->valor=$item['valor'];
            $respuesta->saveOrFail();
        }   

        return $this->api_success([
            'data' => new respuestaExamenResource($respuesta),
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\respuesta_examen  $pregunta
     * @return \Illuminate\Http\Response
     */
    public function show(respuesta_examen $pregunta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function edit(respuesta_examen $pregunta)
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
    public function update(UpdaterespuestaExamenRequest $request, respuesta_examen $respuesta)
    {
        
        if ($request->has("correcto")) {
            $respuesta->correcto = $request->correcto;
        }

        /*if (!$membresia->isDirty()) {
            return $this->errorResponse(
                'Se debe especificar al menos un valor diferente para actualizar',
                422
            );
        }*/

        $respuesta->saveOrFail();

        return $this->api_success([
            'data'      =>  new respuestaExamenResource($respuesta),
            'message'   => __('pages.responses.updated'),
            'code'      =>  201
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy(respuesta_examen $respuesta)
    {
        
    }
}
