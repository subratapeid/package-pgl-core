<?php

namespace Pgl\Core\Api\Concerns;

use Illuminate\Http\JsonResponse;

trait InteractsWithApiResponses
{
    /**
     * @param array<string, mixed> $data
     */
    protected function success(array $data = [], string $message = 'OK', int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    /**
     * @param array<string, mixed> $errors
     */
    protected function error(string $message, int $status = 422, array $errors = []): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }
}
