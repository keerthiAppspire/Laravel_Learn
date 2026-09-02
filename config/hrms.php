<?php
return[
    'leave'=>[
        'annual_quota_days'=>env('HRMS_ANNUAL_QUOTA_DAYS', 20),
        'max_carry_forward_days'=>env('HRMS_MAX_CARRY_FORWARD_DAYS', 15),
    ],
    'payroll'=>[
        'currency'=>env('HRMS_CURRENCY', 'USD'),
    ],
];