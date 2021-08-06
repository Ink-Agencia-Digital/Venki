<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Api\ApiController;
use App\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Http\Request;

class user_adminController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::select('users.id as user_id','users.name as user_name','users.lastname as user_lastname','users.email as user_email','users.password as user_password','roles.id as role_id','roles.name as role_name')
                    ->join('roles','roles.id','=','users.role_id')->where('roles.name','!=','super-admin')->where('users.role_id','!=','null')->get();
        return response()->json([
            'data'=>$users,
        ]);
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
        $user = new User();
        $user->fill($request->all());
        $user->saveOrFail();
        return $this->api_success([
            'data' => $request->password,
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if ($request->has("name")) {
            $user->name = $request->name;
        }
        if ($request->has("lastname")) {
            $user->lastname = $request->lastname;
        }
        if($request->has("password")){
            $user->password = $request->password;
        }
        if (!$user->isDirty()) {
            return $this->errorResponse(
                'Se debe especificar al menos un valor diferente para actualizar',
                422
            );
        }
        $user->saveOrFail();

        return $this->api_success([
            'data'      =>  new UserResource($user),
            'message'   => __('pages.responses.updated'),
            'code'      =>  201
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    
}
