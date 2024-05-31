<?php

namespace App\Http\Controllers;

use App\Events\NewUserEvent;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(UserRegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'isValidEmail' => User::IS_INVALID_EMAIL,
            'remember_token' => Str::random(60)
        ]);

        NewUserEvent::dispatch($user);

        return response()->json([
            'message' => 'Usuario creado exitosamente',
        ]);
    }

    public function login(UserLoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->input('email'))->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'message' => 'Email y/o contraseña incorrectos',
                'isLoggedIn' => false,
            ], 401);
        }

        if (intval($user->isValidEmail) !== User::IS_VALID_EMAIL) {
            NewUserEvent::dispatch($user);
            return response()->json([
                'message' => 'Necesitas verificar su correo electrónico para poder acceder a la aplicación',
                'isLoggedIn' => false
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        return response()->json([
            'message' => 'Usuario autenticado exitosamente',
            'user' => $user,
            'token' => $token,
            'isLoggedIn' => true
        ]);
    }

    function checkEmail($token): JsonResponse
    {
        $user = User::where('remember_token', $token)->first();
        if (!$user) {
            return response()->json([
                'message' => 'El token proporcionado no es válido',
            ]);
        }

        $user->isValidEmail = User::IS_VALID_EMAIL;
        $user->save();

        return response()->json([
            'message' => 'Email verificado exitosamente',
            'user' => $user
        ]);
    }
}
