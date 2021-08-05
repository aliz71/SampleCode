<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

class ResponseService
{
    public function respond(iterable $data = [], int $statusCode = 200, array $headers = []): JsonResponse
    {
        if ($statusCode == 200) {
            $output = [
                'data' => $data
            ];
        } else {
            $output = [
                'error' => $data
            ];
        }
        return response()->json($output, $statusCode, $headers);
    }
}
