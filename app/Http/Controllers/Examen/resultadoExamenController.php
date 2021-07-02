<?php

namespace App\Http\Controllers\Examen;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\resultado_examen;

class resultadoExamenController extends ApiController
{
    //
    public function index($iduser)
    {
        $resultados = resultado_examen::join('users','users.id','=','resultados_examen.id_user')
                        ->join('examenes','examenes.id','=','resultados_examen.id_examen')
                        ->join('courses','courses.id','=','examenes.id_course')
                        ->join('trofeos','trofeos.id','=','resultados_examen.id_trofeo')
                        ->where('id_user','=',$iduser)->get();
        return response()->json([
            'data'=>$resultados
        ]);
    }
}
