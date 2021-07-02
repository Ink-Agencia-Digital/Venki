<?php

namespace App\Http\Controllers\Coin;

use App\Coin;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\StoreCoinRequest;
use App\Http\Resources\CoinResource;
use Illuminate\Http\Request;

class CoinController extends ApiController
{
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
    public function store(StoreCoinRequest $request)
    {
        $coin = new Coin;
        $coin->fill($request->all());
        $coin->saveOrFail();

        return $this->api_success([
            'data' => new CoinResource($coin),
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Coin  $coin
     * @return \Illuminate\Http\Response
     */
    public function show(Coin $coin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Coin  $coin
     * @return \Illuminate\Http\Response
     */
    public function edit(Coin $coin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Coin  $coin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coin $coin)
    {
        if ($request->has('magin'))
        {
            $coin->magin = $coin->magin + $request->magin;
        }

        if (!$coin->isDirty()) {
            return $this->errorResponse(
                'Se debe especificar al menos un valor diferente para actualizar',
                422
            );
        }
        $coin->saveOrFail();
        return $this->api_success([
            'data' => new CoinResource($coin),
            'message'   => __('pages.responses.updated'),
            'code'      =>  200
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Coin  $coin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coin $coin)
    {
        //
    }
}
