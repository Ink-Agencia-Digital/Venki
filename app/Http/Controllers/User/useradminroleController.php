<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Api\ApiController;
use App\roles;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class useradminroleController extends ApiController
{
    public function index()
    {
        $roles = roles::select('id','name','opcmenu')->where('opcmenu','!=','null')->get();
        return response()->json([
            'data'=>$roles
        ]);
    }
}
