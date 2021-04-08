<?php

namespace App\Http\Controllers\Feeling;

use App\Feeling;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\StoreFeelingRequest;
use App\Http\Resources\FeelingResource;
use Illuminate\Http\Request;

class FeelingController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(StoreFeelingRequest $request)
    {
        $feeling = new Feeling;
        $feeling->fill($request->all());
        $feeling->saveOrFail();

        return $this->api_success([
            'data' => new FeelingResource($feeling),
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Feeling  $feeling
     * @return \Illuminate\Http\Response
     */
    public function show(Feeling $feeling)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Feeling  $feeling
     * @return \Illuminate\Http\Response
     */
    public function edit(Feeling $feeling)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Feeling  $feeling
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feeling $feeling)
    {
        if ($request->has('name'))
        {
            $feeling->name = $request->name;
        }

        if (!$feeling->isDirty()) {
            return $this->errorResponse(
                'Se debe especificar al menos un valor diferente para actualizar',
                422
            );
        }

        $feeling->saveOrFail();
        return $this->api_success([
           'data' => new FeelingResource($feeling),
            'message'   => __('pages.responses.updated'),
            'code'      =>  200
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Feeling  $feeling
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feeling $feeling)
    {
        //
    }
}
