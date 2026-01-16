<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Validation\ValidationException;

class CartService
{
    public function getCart(int $userId): Cart
    {
        return Cart::firstOrCreate(['user_id' => $userId]);
    }

    public function add(int $userId, int $productId, int $quantity): void
    {
        $product = Product::findOrFail($productId);

        if ($quantity > $product->stock) {
            throw ValidationException::withMessages([
                'quantity' => 'Quantity exceeds available stock',
            ]);
        }

        $cart = $this->getCart($userId);

        $item = CartItem::firstOrNew([
            'cart_id' => $cart->id,
            'product_id' => $productId,
        ]);

        $newQuantity = ($item->exists ? $item->quantity : 0) + $quantity;

        if ($newQuantity > $product->stock) {
            throw ValidationException::withMessages([
                'quantity' => 'Total quantity exceeds available stock',
            ]);
        }

        $item->quantity = $newQuantity;
        $item->save();
    }

    public function view(int $userId)
    {
        $cart = $this->getCart($userId);

        return $cart->items()->with('product.vendor')->get()
            ->groupBy(fn ($item) => $item->product->vendor_id);
    }

    public function updateItem(int $itemId, int $quantity): void
    {
        $item = CartItem::with('product')->findOrFail($itemId);

        if ($quantity > $item->product->stock) {
            throw ValidationException::withMessages([
                'quantity' => 'Quantity exceeds available stock',
            ]);
        }

        $item->update(['quantity' => $quantity]);
    }

    public function removeItem(int $itemId): void
    {
        CartItem::findOrFail($itemId)->delete();
    }
}