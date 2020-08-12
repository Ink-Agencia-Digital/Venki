<?php

/**
 * Created by PhpStorm.
 * User: ricar
 * Date: 26/03/2019
 * Time: 1:29 PM
 */

namespace App\Traits;


use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

trait MessagePush
{
    protected function sendPush($message, $deviceToken)
    {
        $messaging = app('firebase.messaging');
        $title = 'Nuevo Mensaje';
        $body = $message;

        $notification = Notification::create($title, $body);
        $message = CloudMessage::withTarget('token', $deviceToken)
            ->withNotification($notification) // optional
            ->withData(["message" => $message]);

        $messaging->send($message);
    }
}
