<?php

namespace App\Http\Controllers\Examen;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use App\pregunta_examen;
use App\examen;
use App\user_course_lesson;
use App\Http\Resources\PreguntaExamenResource;


class examenpreguntasController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($idexamen)
    {
        
        //return $this->collectionResponse(PreguntaExamenResource::collection($this->getModel(new pregunta_examen,['examen'],$preguntas)));
        //$exa = examen::find($idexamen);
        $preguntas = pregunta_examen::where('id_examen','=',$idexamen)->get();
        //$lessons = user_course_lesson::where('id_user',71)->where('id_course',7)->get();
        return response()->json([
            'data'=>$preguntas
            //'preguntas'=>$preguntas
        ]);
    }
    
}
