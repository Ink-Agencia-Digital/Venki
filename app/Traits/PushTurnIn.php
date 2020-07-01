<?php

namespace App\Traits;

trait PushTurnIn
{
    private function sendPush($device, $title, $body, $notId)
    {
        $notification = array(
            'body' => $body, //este mensaje sera el mismo para todos los coordinadores
            'title' => $title, //este titulo sera el mismo para todos los coordinadores
            'sound' => 'default',
            'icon' => 'guardian',
            'color' => "#4D0101",
            //'content_available'=> true,
            'force-start' => 1,
            "soundname" => "default"
            //'foreground' => false
        );
        $fields = array(
            'to' => $device,
            'priority' => 'high',
            'content_available' => true,
            //'data' => $notification, //este parametro ejecuta el callback de la notificacion cuando esta en primer plano.
            'notification' => $notification
        );
        $headers = array(
            'Authorization: key=AIzaSyCElGvQiSmwuP2yib8aGPeG13YiIsqjD5M',
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
