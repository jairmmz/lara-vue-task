<?php

namespace App\Classes;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiResponseHelper
{
    public static function rollback($e, $message = 'Fallo en el proceso', $status = 500)
    {
        DB::rollBack();
        self::throw($e, $message, $status);
    }

    public static function throw($e, $message = 'Fallo en el proceso', $status = 500)
    {
        Log::info($e->getMessage());
        throw new HttpResponseException(response()->json([
            'message' => $message,
        ], $status));
    }

    public static function sendRespone($data, $message = '', $status = 200)
    {
        if ($status === 204) {
            return response()->noContent();
        }

        $response = [
            'success' => true,
            'data' => $data,
        ];

        if (!empty($message)) {
            $response['message'] = $message;
        }

        return response()->json($response, $status);
    }
}
