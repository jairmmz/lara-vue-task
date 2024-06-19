<?php

namespace App\Services;

use App\DataTransferObjects\UserDto;
use App\Events\NewUserEvent;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthService
{
    public function register(UserDto $dto): UserResource
    {
        $data = [
            'email' => $dto->email,
            'password' => Hash::make($dto->password),
            'isValidEmail' => User::IS_INVALID_EMAIL,
            'remember_token' => Str::random(60)
        ];

        $user = User::create($data);
        NewUserEvent::dispatch($user);

        return UserResource::make($user);
    }

    public function login(UserDto $dto): array
    {
        $user = User::where('email', $dto->email)->first();

        if (!$user || !Hash::check($dto->password, $user->password)) {
            return ['message' => ['Email y/o contraseña incorrectos'], 'status' => Response::HTTP_UNAUTHORIZED];
        }

        if (intval($user->isValidEmail) !== User::IS_VALID_EMAIL) {
            NewUserEvent::dispatch($user);
            return ['message' => ['Necesitas verificar su correo electrónico para poder acceder a la aplicación'], 'status' => Response::HTTP_UNAUTHORIZED];
        }

        /** @var \App\Models\User $user */
        $token = $user->createToken('auth_token')->plainTextToken;

        return ['user' => UserResource::make($user), 'token' => $token];
    }

    public function checkEmail(string $token): array | bool
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