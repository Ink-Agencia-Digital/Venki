<?php

namespace App\Http\Controllers\Examen;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\respuesta_examen;
use App\Examen;
use App\Http\Resources\respuestaExamenResource;
use App\Http\Requests\StorerespuestaExamenRequest;
use App\Http\Requests\UpdaterespuestaExamenRequest;
use App\pregunta_examen;
use App\resultado_examen;
use App\trofeo;

class respuestaExamenController extends ApiController
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($iduser,$idexamen)
    {
        $respuestas = respuesta_examen::where('id_user','=',$iduser)->where('id_examen','=',$idexamen)->get();
        return response()->json([
            'data'=>$respuestas
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
        $valorcorrecto =(float)0;
        $idexamen = null;
        $iduser=null;
        foreach($request->all() as $item)
        {
            $idexamen =$item['id_examen'];
            $iduser = $item['id_user'];
            $valorcorrecto +=(float)$item['valor'];
            $respuesta=respuesta_examen::where('id','=',$item['id'])->update(['correcto'=>1]);
        }
        $valorexamen = pregunta_examen::where('id_examen','=',$idexamen)->get();
        $totalexamen=(float)0;
        foreach($valorexamen->all() as $pregunta)
        {
            $totalexamen+=(float)$pregunta['valor'];
        }
        $nota = ($valorcorrecto/(float)$totalexamen)*100;
        $trofeo = trofeo::select('id')->where('rangoini','<=',$nota)->where('rangofin','>=',$nota)->get();
        $resultadoexamen = new resultado_examen();
        $resultadoexamen->id_user=$iduser;
        $resultadoexamen->id_examen=$idexamen;
        $resultadoexamen->id_trofeo=$trofeo[0]->id;
        $resultadoexamen->nota=$nota;
        $resultadoexamen->save(); 
        return response()->json([
            'data'=>$resultadoexamen
        ]) ;
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
