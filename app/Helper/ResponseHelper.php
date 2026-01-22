<?php

namespace App\Helper;

use Illuminate\Http\JsonResponse;

class ResponseHelper
{
    public static function Out($status, $message, $data = null, $statusCode = 200): JsonResponse
    {
        // Ensure that status code is a valid integer
        if (!is_int($statusCode)) {
            $statusCode = 200;
        }
        return response()->json([
            'status' => $status,
            'message' => ucwords($message),
            'data' => $data
        ], $statusCode);
    }
}
