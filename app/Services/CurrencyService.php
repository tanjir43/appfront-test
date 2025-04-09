<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Contracts\Services\CurrencyServiceInterface;

class CurrencyService implements CurrencyServiceInterface
{
    private const EXCHANGE_RATE_API = 'https://open.er-api.com/v6/latest/USD';

    private const CACHE_KEY = 'exchange_rate_usd_to_eur';

    private const CACHE_DURATION = 60;

    private const FALLBACK_RATE = 0.85;

    public function getUsdToEurExchangeRate(): float
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_DURATION, function () {
            try {
                $response = Http::timeout(5)->get(self::EXCHANGE_RATE_API);

                if ($response->successful()) {
                    $data = $response->json();

                    if (isset($data['rates']['EUR'])) {
                        return (float) $data['rates']['EUR'];
                    }
                }
            } catch (Exception $e) {
                Log::error('Failed to fetch exchange rate: ' . $e->getMessage());
            }

            return (float) env('EXCHANGE_RATE', self::FALLBACK_RATE);
        });
    }
}
