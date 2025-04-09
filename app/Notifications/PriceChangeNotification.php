<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PriceChangeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Product $product;
    protected float|string $oldPrice;
    protected float|string $newPrice;

    public function __construct(Product $product, float|string $oldPrice, float|string $newPrice)
    {
        $this->product = $product;
        $this->oldPrice = $oldPrice;
        $this->newPrice = $newPrice;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Product Price Change Notification')
            ->view('emails.price-change', [
                'product' => $this->product,
                'oldPrice' => $this->oldPrice,
                'newPrice' => $this->newPrice
            ]);
    }
}
