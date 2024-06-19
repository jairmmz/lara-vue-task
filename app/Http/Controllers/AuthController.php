<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\UserDto;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {}

    public function register(UserRegisterRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $user = $this->authService->register(UserDto::requestRegister($request));
            DB::commit();
            return $this->success('Usuario registrado exitosamente', $user);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->badRequest('Ocurrio un error inesperado', $e->getMessage());
        }
    }

    public function login(UserLoginRequest $request)
    {
        try {
            $user = $this->authService->login(UserDto::requestLogin($request));

            if (isset($user['status']) == Response::HTTP_UNAUTHORIZED) {
                return $this->badRequest('Error de validación', $user['message']);
            }
            return $this->success('Usuario autenticado exitosamente', $user);    
        } catch (Exception $e) {
            return $this->badRequest('Ocurrio un error inesperado', $e->getMessage());
        }
    }

    public function checkEmail(string $token)
    {
        $user = $this->authService->checkEmail($token);

        if (!$user) {
            return 'Token inválido';
        }

        return $this->success('Email verificado exitosamente, cierre esta pestaña y vuelva a la aplicación.');
    }

    public function logout(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->tokens()->delete();
        
        return $this->success('Sesión cerrada exitosamente');
    }
}
