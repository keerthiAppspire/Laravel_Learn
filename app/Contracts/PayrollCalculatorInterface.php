<?php

namespace App\Contracts;

interface PayrollCalculatorInterface
{
    public function calculate(float $salary): float;
}
