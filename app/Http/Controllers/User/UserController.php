<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Mail;
class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->collectionResponse(UserResource::collection($this->getModel(new User, ['roles', 'profile'])));
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
    public function store(StoreUserRequest $request)
    {

        $user = new User;
        $user->fill($request->all());
	    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        // Output: 54esmdr0qf
        $user->confirmation_code=substr(str_shuffle($permitted_chars), 0, 10);
        if ($request->hasFile('photo')) {
            $user->photo = $request->photo->store('images');
        }

        if ($request->register_social == 'true') {

            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $password_social = substr(str_shuffle($permitted_chars), 0, 8);
            $user->password = $password_social;
            $user->register_social = 1;
            $user->saveOrFail();

            $data=['email' => $user->email,'name' => $user->name,'confirmation_code' => $user->confirmation_code, 'password_social' => $password_social];
            Mail::send('confirmation_code_social', $data, function($message) use ($data) {
                $message->to($data['email'], $data['name'])->subject('Por favor confirma tu correo');
            });

        } else {
            $user->saveOrFail();
            $data=['email' => $user->email,'name' => $user->name,'confirmation_code' => $user->confirmation_code];
            Mail::send('confirmation_code', $data, function($message) use ($data) {
                $message->to($data['email'], $data['name'])->subject('Por favor confirma tu correo');
            });
        }

        return $this->api_success([
            'data' => new UserResource($user),
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
        return $this->singleResponse(new UserResource($user));
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
    public function update(UpdateUserRequest $request, User $user)
    {
        if ($request->has("name")) {
            $user->name = $request->name;
        }
        if ($request->has("email")) {
            $user->email = $request->email;
        }
        if ($request->has("lastname")) {
            $user->lastname = $request->lastname;
        }
        if ($request->has("birthday")) {
            $user->birthday = $request->birthday;
        }
        if ($request->has("phone")) {
            $user->phone = $request->phone;
        }
        if ($request->has("description")) {
            $user->description = $request->description;
        }
        if ($request->has("institution")) {
            $user->institution = $request->institution;
        }
        if ($request->has("status")) {
            $user->status = $request->status;
        }
        if ($request->has("city")) {
            $user->city = $request->city;
        }
        if ($request->has("avatar")) {
            $user->avatar = $request->avatar;
        }

        if ($request->has("photo")) {
            if ($user->photo)
                Storage::delete($user->photo);
            $image = $request->photo;
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = Str::random(10) . '.jpeg';
            Storage::disk('photos')->put($imageName, base64_decode($image));
            $user->photo =  $imageName;
        }

        if ($request->has("profile_id")) {
            $user->profile_id = $request->profile_id;
        }

        if ($request->has("surveyed")) {
            $user->surveyed = $request->surveyed;
        }
        if ($request->has("premium")) {
            $user->premium = $request->premium;
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
        $user->delete();
        return $this->api_success([
            'data'      =>  new UserResource($user),
            'message'   => __('pages.responses.deleted'),
            'code'      =>  200
        ], 200);
    }
}
