<?php

namespace App\Http\Controllers\Graficos;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\User;
use App\UserCourse;
use App\pago;

class graficosController extends ApiController
{
    public function users()
    {
        $usuarios=User::select('created_at as labels',User::raw('COUNT(id) as datasets'))->groupBy('created_at')->get();
        return response()->json([
            'data'=>$usuarios
        ]);
    }
    
    public function premiumusers()
    {
        $usuariosfree=User::select('Premium as labels',User::raw('COUNT(id) as datasets'))->where('Premium','=','0')->groupBy('Premium');
        $usuariospago = User::select('Premium as labels',User::raw('COUNT(id) as datasets'))->where('Premium','=','1')->union($usuariosfree)->groupBy('Premium')->get();
        return response()->json([
            'data'=>$usuariospago
        ]);
    }

    public function usersprofile()
    {
        $userprofile = User::select('profiles.name as labels',User::raw('COUNT(users.id) as datasets'))
                    ->join('profiles','profiles.id','=','users.profile_id')->groupBy('users.profile_id')->get();
        return response()->json([
            'data'=>$userprofile
        ]);
    }

    public function courseusers()
    {
        $courseuser = UserCourse::select('courses.name as labels',UserCourse::raw('COUNT(users_courses.user_id) as datasets'))
                        ->join('courses','courses.id','=','users_courses.course_id')->groupBy('users_courses.course_id')->get();
        return response()->json([
            'data'=>$courseuser
        ]);
    }
    
    public function pagosmembresia()
    {
        $pagos = pago::select('membresias.nombre as labels',pago::raw('SUM(pagos.x_amount_base) as datasets'))
                ->join('membresias','membresias.id','=','pagos.membresia_id')->where('pagos.x_response','=','Aceptada')
                ->groupBy('pagos.membresia_id')->get();
        return response()->json([
            'data'=>$pagos
        ]);
    }

    public function pagosmes()
    {
        $pagosmes = pago::select(pago::raw('MONTH(pagos.x_transaction_date) as labels'),pago::raw('SUM(pagos.x_amount_base) as datasets'))
                    ->where('pagos.x_response','=','Aceptada')
                    ->where('YEAR(pagos.x_transaction_date)','=','YEAR(NOW())')
                    ->groupBy('labels')->get();
        return response()->json([
            'data'=>$pagosmes
        ]);
    }


}
