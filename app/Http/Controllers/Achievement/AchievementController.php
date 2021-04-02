<?php

namespace App\Http\Controllers\Achievement;

use App\Achievement;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\AchievementResource;
use Illuminate\Http\Request;

class AchievementController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->collectionResponse(AchievementResource::collection($this->getModel(new Achievement, [])));
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
    public function store(Request $request)
    {
        if ($request->has('objectives')) {
            foreach ($request->objectives as $objective) {
                $achievement = new Achievement([
                    'achievement' => $objective['achievement'],
                    'priority' => $objective['priority'],
                    'date' => $objective['date'],
                    'user_id' => $request->user_id
                ]);
                $achievement->save();
            }
        } else {
            return $this->errorResponse(
                'Se debe especificar al menos un objetivo',
                422
            );
        }

        return $this->api_success([
            'message'   => 'objetivos agregados correctamente!',
            'code'      =>  201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Achievement  $achievement
     * @return \Illuminate\Http\Response
     */
    public function show(Achievement $achievement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Achievement  $achievement
     * @return \Illuminate\Http\Response
     */
    public function edit(Achievement $achievement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Achievement  $achievement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Achievement $achievement)
    {
        if ($request->has('achievement')) {
            $achievement->achievement = $request->achievement;
        }

        if ($request->has('priority')) {
            $achievement->priority = $request->priority;
        }

        if ($request->has('date')) {
            $achievement->date = $request->date;
        }

        if (!$achievement->isDirty()) {
            return $this->errorResponse(
                'Se debe especificar al menos un valor diferente para actualizar',
                422
            );
        }

        $achievement->saveOrFail();

        return $this->api_success([
            'data'      =>  new AchievementResource($achievement),
            'message'   => __('pages.responses.updated'),
            'code'      =>  200
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Achievement  $achievement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Achievement $achievement)
    {
        $achievement->delete();
        return $this->api_success([
            'data'      =>  new AchievementResource($achievement),
            'message'   => __('pages.responses.deleted'),
            'code'      =>  201
        ], 201);
    }
}
