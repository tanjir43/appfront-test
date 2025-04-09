<?php

namespace App\Events;

use App\Models\Product;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ProductPriceChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Product $product;

    public float|string $oldPrice;

    public float|string $newPrice;

    public function __construct(Product $product, float|string $oldPrice, float|string $newPrice)
    {
        $this->product = $product;
        $this->oldPrice = $oldPrice;
        $this->newPrice = $newPrice;
    }
}
