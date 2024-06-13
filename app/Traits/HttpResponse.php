<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait HttpResponse
{
    public function success(string $message,  $data = null, $code = 200): JsonResponse
    {
        return response()->json(["message" => $message, "data" => $data, "code" => $code], $code);
    }

    public function badRequest(string $message, $data = null, $code = 400): JsonResponse
    {
        return response()->json(["message" => $message, "data" => $data, "code" => $code], $code);
    }

    public function notFound(): JsonResponse
    {
        return response()->json(["message" => "Información no encontrada en el servidor.", "code" => 404], 404);
    }
    public function unauthorized(): JsonResponse
    {
        return response()->json(["message" => "No autorizado!", "code" => 401], 401);
    }
    public function forbidden(): JsonResponse
    {
        return response()->json(["message" => "Prohibido el acceso!", "code" => 403], 403);
    }
}
