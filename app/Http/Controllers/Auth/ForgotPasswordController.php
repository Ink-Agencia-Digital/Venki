<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Mail;

class ForgotPasswordController extends ApiController
{
    public function forgot(Request $request) {

        $this->validate($request, [
            'email' => 'required|email|exists:users'
        ]);

        $password_reset = $this->randomPassword();
        $user = User::Where('email', $request->email)->first();
        $user->password = $password_reset;
        $user->register_social = 1;
        $user->saveOrFail();

        $data=['email' => $user->email,'name' => $user->name, 'password_reset' => $password_reset];
        Mail::send('password_reset', $data, function($message) use ($data) {
            $message->to($data['email'], $data['name'])->subject('Por inicia sesion para reestablecer contraseña');
        });

        return $this->api_success([
            'data' => new UserResource($user),
            'message' => 'Email enviado para reestablecer contraseña!',
            'code' => 200
        ]);
    }

    public function reset(Request $request) {

        $validations = [
            'user_id' => 'required|exists:users,id',
            'password' => 'required|min:8',
            'confirmed_password' => 'required|same:password'
        ];

        $this->validate($request, $validations);
        $user = User::where('id', $request->user_id)->first();
        $user->password = $request->password;
        $user->register_social = 0;
        $user->saveOrFail();

        return $this->api_success([
            'data' => new UserResource($user),
            'message' => 'Password update successful!',
            'code' => 200
        ]);
    }

    public function randomPassword($len = 8) {
        if($len < 8)
            $len = 8;

        $sets = array();
        $sets[] = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        $sets[] = '23456789';
        $sets[]  = '~!@#$%^&*(){}[],./?';

        $password = '';

        foreach ($sets as $set) {
            $password .= $set[array_rand(str_split($set))];
        }

        while(strlen($password) < $len) {
            $randomSet = $sets[array_rand($sets)];
            $password .= $randomSet[array_rand(str_split($randomSet))];
        }

        return str_shuffle($password);
    }
}
