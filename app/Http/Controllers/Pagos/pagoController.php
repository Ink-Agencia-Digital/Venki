<?php

namespace App\Http\Controllers\Pagos;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\PagoResource;
use App\pago;
use Illuminate\Http\Request;

class pagoController extends ApiController
{
    public function index()
    {
        return $this->collectionResponse(PagoResource::collection($this->getModel(new pago,['users','membresias'])));
    }
}
