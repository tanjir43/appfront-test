<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class PriceChangeNotification extends Mailable
{
    public $product;
    public $oldPrice;
    public $newPrice;

    public function __construct($product, $oldPrice, $newPrice)
    {
        $this->product = $product;
        $this->oldPrice = $oldPrice;
        $this->newPrice = $newPrice;
    }

    public function build()
    {
        return $this->subject('Product Price Change Notification')
            ->view('emails.price-change');
    }
}
