<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function create(CreateOrderRequest $request): JsonResponse
    {
        // Retrieve validated input data
        $validated = $request->validated();

        Log::info($validated);

        return response()->json(['message' => 'Order created successfully'], 201);
    }
}
