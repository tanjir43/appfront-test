<?php

namespace App\Listeners;

use App\Events\ProductPriceChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Contracts\Services\NotificationServiceInterface;

class SendPriceChangeNotification implements ShouldQueue
{
    use InteractsWithQueue;

    protected NotificationServiceInterface $notificationService;

    public function __construct(NotificationServiceInterface $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function handle(ProductPriceChanged $event): void
    {
        $this->notificationService->sendPriceChangeNotification(
            $event->product,
            $event->oldPrice,
            $event->newPrice
        );
    }
}
