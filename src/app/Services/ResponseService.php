<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

    public function csvDownload(callable $callback, array $headers = [], int $statusCode = 200): StreamedResponse
    {
        return response()->stream($callback, $statusCode, $headers);
    }

    public function xmlDownload(string $data, array $headers = [], int $statusCode = 200): Response
    {
        return Response::create($data, $statusCode, $headers);
    }
}
