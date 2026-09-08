<?php

namespace App\Contracts;

interface ExchangeRateProvider
{
    public function rate(string $from, string $to): float;
}
