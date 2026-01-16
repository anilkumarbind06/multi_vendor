<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CheckoutService;

class CheckoutController extends Controller
{
    public function __construct(private CheckoutService $checkoutService)
    {
    }

    public function checkout()
    {
        $orders = $this->checkoutService->checkout(auth()->id());

        return response()->json([
            'message' => 'Order placed successfully',
            'orders'  => $orders,
        ]);
    }

    public function myOrders()
    {
        return response()->json(
            auth()->user()->orders()->with('items.product')->get()
        );
    }
}
