<?php

namespace App\Services;

use Exception;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PriceChangeNotification;
use App\Contracts\Services\NotificationServiceInterface;

class NotificationService implements NotificationServiceInterface
{
    public function sendPriceChangeNotification(Product $product, float|string $oldPrice, float|string $newPrice): void
    {
        $notificationEmail = config('mail.price_notification_email', 'admin@example.com');

        try {
            Notification::route('mail', $notificationEmail)
                ->notify(new PriceChangeNotification($product, $oldPrice, $newPrice));

            Log::info("Price change notification sent to {$notificationEmail} for product {$product->id}");
        } catch (Exception $e) {
            Log::error("Failed to send price change notification: " . $e->getMessage());
        }
    }
}
