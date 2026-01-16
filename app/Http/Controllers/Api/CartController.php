<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CartService;

class CartController extends Controller
{
    public function __construct(private CartService $cartService)
    {
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $this->cartService->add(
            auth()->id(),
            $request->product_id,
            $request->quantity
        );

        return response()->json(['message' => 'Product added to cart']);
    }

    public function view()
    {
        return response()->json(
            $this->cartService->view(auth()->id())
        );
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $this->cartService->updateItem($id, $request->quantity);

        return response()->json(['message' => 'Cart updated']);
    }

    public function remove($id)
    {
        $this->cartService->removeItem($id);

        return response()->json(['message' => 'Item removed']);
    }
}
