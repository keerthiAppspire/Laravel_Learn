<?php
uses(Tests\TestCase::class);
use App\Services\PayrollCalculatorResolver;
use App\Services\USPayrollCalculator;
use App\Services\DEPayrollCalculator;

test('US country resolves to USPayrollCalculator', function () {
    $resolver = app(PayrollCalculatorResolver::class);
    $calculator = $resolver->resolve('US');
    expect($calculator)->toBeInstanceOf(USPayrollCalculator::class);
});
test('DE country resolves to DE payroll calculator', function () {
    $resolver = app(PayrollCalculatorResolver::class);

    $calculator = $resolver->resolve('DE');

    expect($calculator)->toBeInstanceOf(
        \App\Services\DEPayrollCalculator::class
    );
});
test('unsupported country throws an exception', function () {
    $resolver = app(PayrollCalculatorResolver::class);

    $resolver->resolve('IN');
})->throws(
    InvalidArgumentException::class,
    'Unsupported country: IN'
);