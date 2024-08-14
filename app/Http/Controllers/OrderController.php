<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderPostRequest;
use App\Services\OrderService;

class OrderController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function validateFormat(OrderPostRequest $request): \Illuminate\Http\JsonResponse
    {
        $transformedOrder = $this->orderService->validateAndTransformOrder(
            $request->only(['id', 'name', 'address', 'currency', 'price'])
        );

        return response()->json([
            'data' => [
                'isValid' => true,
                'order'   => $transformedOrder,
            ],
        ]);
    }
}
