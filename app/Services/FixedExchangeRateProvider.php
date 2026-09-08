<?php

namespace App\Services;
use App\Contracts\ExchangeRateProvider;
class FixedExchangeRateProvider implements ExchangeRateProvider
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private array $rates
    ){    
    }
    public function rate(string $from, string $to): float
    {
        return $this->rates[$from . '_' . $to];
    }
}
