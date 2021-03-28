<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
</head>
<body>
    @if(Session::has('message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{Session::get('message')}}
        </div>
    @endif

    <h2>Hola {{ $name }}, gracias por registrarte en <strong> MAGIN </strong> !</h2>
    <p>Por favor confirma tu correo electrónico.</p>
    <p>Para ello simplemente debes hacer click en el siguiente enlace:</p>

    <a href="{{ url('api/register/verify/' . $confirmation_code) }}">
        Clic para confirmar tu email
    </a>
</body>
</html>
