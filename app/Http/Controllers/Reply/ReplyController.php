<?php

namespace App\Http\Controllers\Reply;

use App\Category;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\ReplyResource;
use App\Reply;
use Illuminate\Http\Request;

class ReplyController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->collectionResponse(ReplyResource::collection($this->getModel(new Reply, ['user'])));
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
        $reply = new Reply;
        $reply->fill($request->all());
        $reply->saveOrFail();

        return $this->api_success([
            'data' => new ReplyResource($reply),
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function show(Reply $reply)
    {
        $replies = collect($reply->reply)->groupBy('ct');

        $average = array();
        $replies->each(function ($item, $key) use (&$average) {
            $category = Category::findOrFail($key);
            $average[$category->name] = round(($item->pluck('r')->reduce(function ($carry, $item) {
                return $carry + $item;
            })) / ($item->count()), 2);
        });
        $reply = $reply->load(['user.courses','survey.profile'])->toArray();
        $reply["reply"] = $average;
        return $this->singleResponse(new ReplyResource($reply));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function edit(Reply $reply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reply $reply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        $reply->delete();
        return $this->api_success([
            'data' => new ReplyResource($reply),
            'message' => __('pages.responses.deleted'),
            'code' => 201
        ], 201);
    }
}
