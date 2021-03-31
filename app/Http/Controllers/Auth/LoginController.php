<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\LinkedSocialAccount;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Traits\ApiResponser;

class LoginController extends ApiController
{
     /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($socialNetwork)
    {
        if (collect(['facebook', 'google'])->contains($socialNetwork)) {
            return Socialite::driver($socialNetwork)->redirect();
        }

        return $this->errorResponse(
            "No fue posible autenticarse con {$socialNetwork}.",
            422
        );

    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($socialNetwork)
    {
        try {
            $socialUser = Socialite::driver($socialNetwork)->user();
        } catch (\Exception $exception) {
            return $this->errorResponse(
                "Hubo un error obteniendo los datos del usuario...",
                422
            );
        }

        // verificar que existe un identificador de usuario de la red social
        $socialProfile = LinkedSocialAccount::query()->firstOrNew([
            'provider_name' => $socialNetwork,
            'provider_id' => $socialUser->getId(),
        ]);

        //si no existe entra en el if
        if (!$socialProfile->exists()) {

            //Verifica si existe un usuario con el email de la red social
            $user = User::query()->firstOrNew(['email' => $socialUser->getEmail()]);

            // si no existe el usuario con ese email en la bd entra en el if y crear el usuario
            if (!$user->exists()){
                $user->name = $socialUser->getName();
                $user->save();
            }

            // si existe el usuario con el email
            $user->avatar = $socialUser->getAvatar();
            $user->linkedSocialAccounts()->save($socialProfile);
        }

        //si existe en la bd este perfil redirige al issueToken y autentica con passport
        // metodo de autenticacion con laravel passport
        // return redirect()->route('home')->with('success', 'Bienvenido'. $socialProfile->user->name);


    }
}
