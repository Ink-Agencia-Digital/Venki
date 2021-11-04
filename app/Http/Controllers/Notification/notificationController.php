<?php

namespace App\Http\Controllers\Notification;

use Illuminate\Http\Request;
use App\notification;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\NotificationResource;
use App\Http\Requests\StoreNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use OneSignal;


class notificationController extends ApiController
{
    public function index()
    {
        $notifications = notification::select('notifications.id','notifications.titulo','notifications.mensaje','notifications.id_profile','profiles.name')->join('profiles','profiles.id','=','notifications.id_profile')->get();
        return response()->json([
            'data'=>$notifications
        ]);
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
    public function store(StoreNotificationRequest $request)
    {
        $notification = new notification;
        $notification->fill($request->all());
        $notification->saveOrFail();
        OneSignal::sendNotificationToAll(
            $notification->mensaje, 
            $url = null, 
            $data = null, 
            $buttons = null, 
            $schedule = null
        );
        return $this->api_success([
            'data' => new NotificationResource($notification),
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
    public function show(notification $notification)
    {
        return $this->singleResponse(new NotificationResource($notification));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\notification  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $notification = notification::findOrFail($id);
        if ($request->has("titulo")) {
            $notification->titulo = $request->titulo;
        }
        if ($request->has("mensaje")) {
            $notification->mensaje = $request->mensaje;
        }
        if($request->has("id_profile")){
            $notification->id_profile = $request->id_profile;
        }
        if (!$notification->isDirty()) {
            return $this->errorResponse(
                'Se debe especificar al menos un valor diferente para actualizar',
                422
            );
        }

        $notification->saveOrFail();

        /*return $this->api_success([
            'data'      =>  new NotificationResource($notification),
            'message'   => __('pages.responses.updated'),
            'code'      =>  201
        ], 201);*/
        return response()->json([
            'data'=>$notification

        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(notification $notification)
    {
        $notification->delete();
        return $this->singleResponse(new NotificationResource($notification), 200);
    }
}
