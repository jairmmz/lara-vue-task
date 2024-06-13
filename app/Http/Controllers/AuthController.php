<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
            $user = $this->authService->register($request->validated());
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
            $user = $this->authService->login($request->only('email', 'password'));

            if (isset($user['status']) == Response::HTTP_UNAUTHORIZED) {
                return $this->badRequest('Error de validación', $user['message']);
            }
            return $this->success('Usuario autenticado exitosamente', $user);    
        } catch (Exception $e) {
            return $this->badRequest('Ocurrio un error inesperado', $e->getMessage());
        }
    }

    public function checkEmail($token)
    {
        $user = $this->authService->checkEmail($token);

        if (!$user) {
            return 'Token inválido';
        }

        return 'Email verificado exitosamente, cierre esta pestaña y vuelva a la aplicación.';
    }

    public function logout(Request $request)
    {
        DB::table('personal_access_tokens')->where('tokenable_id', $request->userId)->delete();
        // DB::table('personal_access_tokens')->where('token', $request->bearerToken())->delete();
        return $this->success('Sesión cerrada exitosamente');
    }
}
