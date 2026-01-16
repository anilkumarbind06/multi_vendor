<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    /**
     * View all orders (with filters)
     */
    public function index(Request $request)
    {
        $query = Order::with([
            'items.product',
            'vendor',
            'user',
            'payment'
        ]);

        // Optional filters
        if ($request->filled('vendor_id')) {
            $query->where('vendor_id', $request->vendor_id);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return response()->json(
            $query->latest()->get()
        );
    }

    /**
     * View single order details
     */
    public function show($id)
    {
        $order = Order::with([
            'items.product',
            'vendor',
            'user',
            'payment'
        ])->findOrFail($id);

        Gate::authorize('view', $order);

        return response()->json($order);
    }
}
