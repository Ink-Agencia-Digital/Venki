<?php

namespace App\Http\Controllers\Competence;

use App\Competence;
use App\CompetenceMedia;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\CompetenceResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CompetenceController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->collectionResponse(CompetenceResource::collection($this->getModel(new Competence, ['medias'])));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $competence = new Competence;
        $competence->fill($request->all());
        $competence->saveOrFail();

        if ($request->has('images')) {
            foreach ($request->images as $image) {
                $competenceMedia = new CompetenceMedia;
                $image_64 = $image['image'];
                $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
                $image = str_replace('data:image/jpeg;base64,', '', $image_64);
                $image = str_replace(' ', '+', $image);
                $imageName = Str::random(10).'.'.$extension;
                Storage::disk("medias")->put($imageName, base64_decode($image));
                $competenceMedia->media = $imageName;
                $competenceMedia->competence_id = $competence->id;
                $competenceMedia->save();
            }
        }

        if ($request->has('videos')) {
            foreach ($request->videos as $video) {
                $competenceMedia = new CompetenceMedia;
                $image_64 = $video['video'];
                $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
                $image = str_replace('data:video/mp4;base64,', '', $image_64);
                $image = str_replace(' ', '+', $image);
                $imageName = Str::random(10).'.'.$extension;
                Storage::disk("medias")->put($imageName, base64_decode($image));
                $competenceMedia->media = $imageName;
                $competenceMedia->competence_id = $competence->id;
                $competenceMedia->save();
            }
        }

        return $this->api_success([
            'data' => new CompetenceResource($competence->load(['medias'])),
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Competence  $competence
     * @return \Illuminate\Http\Response
     */
    public function show(Competence $competence)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Competence  $competence
     * @return \Illuminate\Http\Response
     */
    public function edit(Competence $competence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Competence  $competence
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Competence $competence)
    {
        if ($request->has('comment')) {
            $competence->comment = $request->comment;
        }

        if ($request->has('type')) {
            $competence->type = $request->type;
        }

        if (!$competence->isDirty()) {
            return $this->errorResponse(
                'Se debe especificar al menos un valor diferente para actualizar',
                422
            );
        }

        $competence->saveOrFail();

        return $this->api_success([
            'data'      =>  new CompetenceResource($competence),
            'message'   => __('pages.responses.updated'),
            'code'      =>  200
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Competence  $competence
     * @return \Illuminate\Http\Response
     */
    public function destroy(Competence $competence)
    {
        $competence->delete();
        return $this->api_success([
            'data' => new CompetenceResource($competence),
            'message' => __('pages.responses.deleted'),
            'code' => 200
        ]);
    }
}
