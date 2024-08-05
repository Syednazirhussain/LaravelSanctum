<?php

namespace App\Http\Controllers\Api;

use App\Contracts\OrderServiceInterface;
use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    public function create(CreateOrderRequest $request): JsonResponse
    {
        // Retrieve validated input data
        $validated = $request->validated();

        Log::info($validated);

        $order = $this->orderService->addOrder($validated);

        Log::info($order);

        $response = [
            'message'   => 'Order created successfully',
            'payload'   => $order
        ];

        return response()->json(['message' => 'Order created successfully'], 201);
    }
}
