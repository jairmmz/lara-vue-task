<?php

namespace App\Services;

use App\Events\NewUserEvent;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthService
{
    public function register(array $data): User
    {
        $data = [
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'isValidEmail' => User::IS_INVALID_EMAIL,
            'remember_token' => Str::random(60)
        ];

        $user = User::create($data);
        NewUserEvent::dispatch($user);

        return $user;
    }

    public function login(array $data): array
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return ['message' => ['Email y/o contraseña incorrectos'], 'status' => Response::HTTP_UNAUTHORIZED];
        }

        if (intval($user->isValidEmail) !== User::IS_VALID_EMAIL) {
            NewUserEvent::dispatch($user);
            return ['message' => ['Necesitas verificar su correo electrónico para poder acceder a la aplicación'], 'status' => Response::HTTP_UNAUTHORIZED];
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }

    public function checkEmail($token): array
    {
        $user = User::where('remember_token', $token)->first();

        if (!$user) {
            return false;
        }

        $user->isValidEmail = User::IS_VALID_EMAIL;
        $user->remember_token = null;
        $user->save();

        return ['message' => 'Email verificado exitosamente', 'isLoggedIn' => true];
    }
}