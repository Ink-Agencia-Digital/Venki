<?php

namespace App\Http\Controllers\Image;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\StoreImageRequest;
use App\Http\Resources\ImageResource;
use App\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->collectionResponse(ImageResource::collection($this->getModel(new Image, [])));
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
    public function store(StoreImageRequest $request)
    {
        $image = new Image;
        $image->fill($request->all());

        if ($request->hasFile('url')) {
            $image->url = $request->url->store('images');
        }
        $image->saveOrFail();

        return $this->api_success([
            'data' => new ImageResource($image),
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $image = Image::find($id)->get();

        if ($request->has('name')) {
            $image->name = $request->name;
        }

        if ($request->has('description')) {
            $image->description = $request->description;
        }

        if ($request->hasFile('url')) {
            Storage::disk('images')->delete($image->url);
            $image->url = $request->url->store('images');
        }

        if (!$image->isDirty()) {
            return $this->errorResponse(
                'Se debe especificar al menos un valor diferente para actualizar',
                422
            );
        }

        $image->saveOrFail();

        return $this->api_success([
            'data'      =>  new ImageResource($image),
            'message'   => __('pages.responses.updated'),
            'code'      =>  200
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        $image->delete();
        return $this->api_success([
            'data' => new ImageResource($image),
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }
}
