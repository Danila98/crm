<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

abstract class ApiController extends Controller
{
    protected function sendError(int $code = 400, string $content = 'error', string $message = 'error'): \Illuminate\Http\JsonResponse
    {
        return Response::json([
            'success' => false,
            'content' => $content,
            'message' => $message,
        ], $code);
    }
    protected function sendResponse(int $code = 200, array $body = [], string $content = 'success'): \Illuminate\Http\JsonResponse
    {
        return Response::json(array_merge(['success' => true], $body), $code);
    }
}
