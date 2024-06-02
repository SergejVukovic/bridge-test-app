<?php


namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait Response
{
    public static function success($data, $message = 'Success', $status = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $status);
    }

    public static function error($message = 'Error', $status = 400): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $status);
    }
}
