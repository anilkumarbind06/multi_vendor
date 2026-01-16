<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendOrderPlacedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderPlaced $event): void
    {
        $order = $event->order;

        // Mock email / notification
        Log::info('Order placed', [
            'order_id' => $order->id,
            'user_id'  => $order->user_id,
            'vendor_id'=> $order->vendor_id,
            'total'    => $order->total,
        ]);
    }
}
