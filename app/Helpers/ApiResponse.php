<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{

    /*
     * @param $data
     * @param $message
     * @param $status
     */
    public static function success($data = null, $message = 'success', $status = 200): JsonResponse
    {
        return response()->json([

            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    /*
     * @param $message
     * @param $status
     */
    public static function error($message = 'error', $status = 500): JsonResponse
    {
        return response()->json([

            'success' => false,
            'message' => $message,
        ], $status);
    }
}
