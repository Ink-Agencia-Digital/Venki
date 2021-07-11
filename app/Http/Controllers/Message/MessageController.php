<?php

namespace App\Http\Controllers\Message;

use App\Events\ChatEvent;
use App\Http\Controllers\Api\ApiController;
use Carbon\Carbon;
use App\Http\Resources\MessageResource;
use App\Message;
use App\Coin;
use App\Traits\MessagePush;
use Illuminate\Http\Request;

class MessageController extends ApiController
{

    use MessagePush;
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
    public function store(Request $request)
    {
        $message = new Message;
        $message->fill($request->all());
        $message->saveOrFail();
        $coin = Coin::where('user_id','=',$message->user_id)->get();
        //se asignan 1 coin al responder mensaje.
        if(($coin->count()>0) && ($coin[0]->user_id==$message->user_id))
        {
            $magins=$coin[0]->magin+1;
            Coin::where('user_id','=',$message->user_id)->update(['magin'=>$magins,'updated_at'=>Carbon::now()]);
        }
        else
        {
            Coin::insert(['user_id'=>$message->user_id,'magin'=>1,'created_at'=>Carbon::now()]);
        }
        return $this->api_success([
            'data' => new MessageResource($message),
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
