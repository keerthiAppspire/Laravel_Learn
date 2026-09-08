<?php

namespace App\Services;
use App\Contracts\ExchangeRateProvider;
use Illuminate\Support\Facades\Http;
class EcbExchangeRateProvider implements ExchangeRateProvider
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function rate(string $from, string $to): float{
        $response = Http::get('https://api.example.com/rates',[
            'from' => $from,
            'to' => $to         
        ]);
        return (float) $response->json()['rate'];
    }
}
