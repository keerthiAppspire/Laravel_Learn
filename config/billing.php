<?php

return [
    'tax_rate' => env('BILLING_TAX_RATE', 18),
    'grace_days' => env('BILLING_GRACE_DAYS', 7),
    'reminder_cadence_days' => env('BILLING_REMINDER_CADENCE_DAYS', 3),
];
