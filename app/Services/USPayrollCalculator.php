<?php

namespace App\Services;
use App\Contracts\PayrollCalculatorInterface;
class USPayrollCalculator implements PayrollCalculatorInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(private float $taxRate)
    {
        //
    }
    public function calculate(float $salary): float{
        return $salary - ($salary * $this->taxRate); 
    }
}
