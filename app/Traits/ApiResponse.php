<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    /**
     * Build a success response
     */
    protected function successResponse(mixed $payload = null, string $message = 'Success', int $code = 200): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'code' => $code,
            'payload' => $payload,
        ], $code);
    }

    /**
     * Build an error response
     */
    protected function errorResponse(string $message = 'Error', int $code = 400, mixed $payload = null): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'code' => $code,
            'payload' => $payload,
        ], $code);
    }
}
