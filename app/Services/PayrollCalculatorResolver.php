<?php

namespace App\Services;
use App\Contracts\PayrollCalculatorInterface;
use InvalidArgumentException;
class PayrollCalculatorResolver
{
    /**
     * Create a new class instance.
     */
    public function __construct( 
        private DEPayrollCalculator $dePayrollCalculator, 
        private USPayrollCalculator $usPayrollCalculator)
    {
        //
    }
    public function resolve(string $country): PayrollCalculatorInterface{
        return match($country){
        'US' => $this->usPayrollCalculator,
        'DE' => $this->dePayrollCalculator,
        default => throw new InvalidArgumentException("Unsupported country: {$country}"),
        };
    }
}
