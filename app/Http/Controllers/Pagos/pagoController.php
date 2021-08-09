<?php

namespace App\Http\Controllers\Pagos;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\PagoResource;
use App\pago;
use App\User;
use Illuminate\Http\Request;

class pagoController extends ApiController
{
    public function index()
    {
        $usuarios = User::select('users.name','users.lastname','users.birthday','users.email','users.premium','membresias.nombre',
                                    'membresias.precio','membresias.duracion','pagos.x_id_factura as factura','pagos.x_amount_base as valor',
                                    'pagos.x_tax as iva','pagos.x_approval_code as aprobacion','pagos.x_transaction_date as fecha_pago',
                                    'pagos.x_cod_response as cod_respuesta','pagos.x_response as respuesta','pagos.x_response_reason_text as texto_respuesta')
                                    ->leftJoin('pagos','users.id','=','pagos.user_id')->leftJoin('membresias','pagos.membresia_id','=','membresias.id')
                                    ->whereNull('users.role_id')->orderBy('pagos.x_transaction_date','desc')
                                    ->get();

        //return $this->collectionResponse(PagoResource::collection($this->getModel(new pago,['users','membresias'])));
        return response()->json([
            'data'=>$usuarios
        ]);
    }
}
