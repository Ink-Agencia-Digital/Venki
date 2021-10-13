<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\UserResource;
use App\User;

class UserUpdateMembresiaController extends ApiController
{
    //
    public function updateMembresia($iduser,$premium)
    {
        User::where('id','=',$iduser)->update(['premium'=>$premium]);
        $user=User::where('id','=',$iduser)->get();

        return $this->api_success([
            'data'      =>  $user,
            'message'   => __('pages.responses.updated'),
            'code'      =>  201
        ], 201);
    }
}
