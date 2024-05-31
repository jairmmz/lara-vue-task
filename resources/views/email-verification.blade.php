<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Verification</title>
</head>

<body>

    <span>Verificación del correo electrónico: {{ $user->email }}</span>
    <a href="{{ route('check_email', ['token' => $user->remember_token]) }}">Verificar Email</a>

</body>

</html>
