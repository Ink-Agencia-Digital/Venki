<?php

namespace App\Http\Controllers\Profile;

use App\Description;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Profile;
use Illuminate\Http\Request;

class ProfileController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->collectionResponse(ProfileResource::collection($this->getModel(new Profile, ['descriptions'])));
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
        $profile = new Profile;
        $profile->fill($request->all());
        $profile->saveOrFail();

        if ($request->has('descriptions')) {
            foreach ($request->descriptions as $descrip) {
                $description = new Description([
                    'profile_id' => $profile->id,
                    'name' => $descrip['name'],
                ]);
                $description->save();
            }
        }

        return $this->api_success([
            'data' => new ProfileResource($profile),
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        $profile->delete();
        return $this->api_success([
            'data' => new ProfileResource($profile),
            'message' => __('pages.responses.deleted'),
            'code' => 201
        ], 201);
    }
}
