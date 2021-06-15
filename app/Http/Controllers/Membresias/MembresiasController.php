<?php

namespace App\Http\Controllers\Membresias;

use Illuminate\Http\Request;
use App\membresia;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\MembresiaResource;
use App\Http\Requests\StoreMembresiaRequest;
use App\Http\Requests\UpdateMembresiaRequest;
use Illuminate\Support\Facades\Storage;

class MembresiasController extends ApiController
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->collectionResponse(MembresiaResource::collection($this->getModel(new membresia)));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMembresiaRequest $request)
    {
        $membresia = new membresia;
        $membresia->fill($request->all());

        if ($request->hasFile('imagen')) {
            $membresia->imagen = $request->imagen->store('images');
        }
        $membresia->saveOrFail();

        return $this->api_success([
            'data' => new MembresiaResource($membresia),
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Membresia  $membresia
     * @return \Illuminate\Http\Response
     */
    public function show(Membresia $membresia)
    {
        return $this->singleResponse(new MembresiaResource($membresia));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Membresia $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Membresia  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMembresiaRequest $request, Membresia $membresia)
    {
        if ($request->has("nombre")) {
            $membresia->nombre = $membresia->nombre;
        }
        if ($request->has("precio")) {
            $membresia->precio = $request->precio;
        }
        if ($request->has("duracion")) {
            $membresia->duracion = $request->duracion;
        }
        if ($request->has("imagen")) {
            Storage::delete($membresia->imagen);
            $membresia->imagen = $request->imagen->store('images');
        }


        if (!$membresia->isDirty()) {
            return $this->errorResponse(
                'Se debe especificar al menos un valor diferente para actualizar',
                422
            );
        }

        $membresia->saveOrFail();

        return $this->api_success([
            'data'      =>  new MembresiaResource($membresia),
            'message'   => __('pages.responses.updated'),
            'code'      =>  201
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Membresia $membresia)
    {
        $membresia->delete();
        return $this->singleResponse(new MembresiaResource($membresia), 200);
    }
}
