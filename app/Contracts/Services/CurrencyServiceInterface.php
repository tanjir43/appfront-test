<?php

namespace App\Contracts\Services;

interface CurrencyServiceInterface
{
    public function getUsdToEurExchangeRate(): float;
}
