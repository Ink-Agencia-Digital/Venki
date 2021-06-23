<?php

namespace App\Http\Controllers\Trofeo;

use Illuminate\Http\Request;
use App\trofeo;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\TrofeoResource;
use App\Http\Requests\StoreTrofeoRequest;
use App\Http\Requests\UpdateTrofeoRequest;
use Illuminate\Support\Facades\Storage;

class trofeoController extends ApiController
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->collectionResponse(TrofeoResource::collection($this->getModel(new trofeo)));
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
    public function store(StoreTrofeoRequest $request)
    {
        $trofeo = new trofeo;
        $trofeo->fill($request->all());

        if ($request->hasFile('imagen')) {
            $trofeo->imagen = $request->imagen->store('images');
        }
        $trofeo->saveOrFail();

        return $this->api_success([
            'data' => new trofeoResource($trofeo),
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\trofeo  $trofeo
     * @return \Illuminate\Http\Response
     */
    public function show(trofeo $trofeo)
    {
        return $this->singleResponse(new trofeoResource($trofeo));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(trofeo $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\trofeo  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatetrofeoRequest $request, trofeo $trofeo)
    {
        if ($request->has("rangoini")) {
            $trofeo->rangoini = $request->rangoini;
        }
        if ($request->has("rangofin")) {
            $trofeo->rangofin = $request->rangofin;
        }
        if ($request->has("nombre")) {
            $trofeo->nombre = $request->nombre;
        }
        if ($request->has("imagen")) {
            Storage::delete($trofeo->imagen);
            $trofeo->imagen = $request->imagen->store('images');
        }
        if (!$trofeo->isDirty()) {
            return $this->errorResponse(
                'Se debe especificar al menos un valor diferente para actualizar',
                422
            );
        }

        $trofeo->saveOrFail();

        return $this->api_success([
            'data'      =>  new trofeoResource($trofeo),
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
    public function destroy(trofeo $trofeo)
    {
        $trofeo->delete();
        return $this->singleResponse(new trofeoResource($trofeo), 200);
    }
}
