<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class GuestController extends Controller
{
    public function verify($code)
{
    echo "Entre aqui";	
    $user = User::where('confirmation_code', $code)->first();
    echo $user;
    if (! $user)
        return redirect('/');
    $user->confirmed = true;
    $user->confirmation_code = null;
    $user->save();
    echo '<script type="text/javascript">
         alert("Tarea Guardada");
        </script>';
    return redirect('/')->with('notification', 'Has confirmado correctamente tu correo!');
}
}
