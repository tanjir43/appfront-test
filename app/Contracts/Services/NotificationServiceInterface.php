<?php

namespace App\Contracts\Services;

use App\Models\Product;

interface NotificationServiceInterface
{
    public function sendPriceChangeNotification(Product $product, float|string $oldPrice, float|string $newPrice): void;
}
