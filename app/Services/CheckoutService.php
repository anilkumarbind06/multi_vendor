<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CheckoutService
{
    public function checkout(int $userId)
    {
        return DB::transaction(function () use ($userId) {

            $cart = Cart::with('items.product.vendor')
                ->where('user_id', $userId)
                ->firstOrFail();

            if ($cart->items->isEmpty()) {
                throw ValidationException::withMessages([
                    'cart' => 'Cart is empty',
                ]);
            }

            // Group cart items by vendor
            $grouped = $cart->items->groupBy(
                fn ($item) => $item->product->vendor_id
            );

            $orders = [];

            foreach ($grouped as $vendorId => $items) {

                $total = 0;

                // Re-check stock (important)
                foreach ($items as $item) {
                    if ($item->quantity > $item->product->stock) {
                        throw ValidationException::withMessages([
                            'stock' => "Insufficient stock for {$item->product->name}",
                        ]);
                    }
                    $total += $item->product->price * $item->quantity;
                }

                // Create order
                $order = Order::create([
                    'user_id'   => $userId,
                    'vendor_id' => $vendorId,
                    'total'     => $total,
                    'status'    => 'placed',
                ]);

                // Create order items & deduct stock
                foreach ($items as $item) {

                    OrderItem::create([
                        'order_id'  => $order->id,
                        'product_id'=> $item->product_id,
                        'price'     => $item->product->price,
                        'quantity'  => $item->quantity,
                    ]);

                    Product::where('id', $item->product_id)
                        ->decrement('stock', $item->quantity);
                }

                // Simulate payment
                Payment::create([
                    'order_id' => $order->id,
                    'status'   => 'paid',
                ]);

                $orders[] = $order;
            }

            // Clear cart
            $cart->items()->delete();

            return $orders;
        });
    }
}
