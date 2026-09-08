<?php
use App\Contracts\ExchangeRateProvider;
use App\Services\FixedExchangeRateProvider;
test('non-production environment uses fixed exchange rate provider', function () {
$provider = app(ExchangeRateProvider::class);
expect($provider)->toBeInstanceOf(FixedExchangeRateProvider::class);
});
