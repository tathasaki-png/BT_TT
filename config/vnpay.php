<?php

return [
    'vnp_TmnCode' => env('VN_PAY_TMN_CODE'),
    'vnp_HashSecret' => env('VN_PAY_HASH_SECRET'),
    'vnp_Url' => env('VN_PAY_URL'),
    'vnp_Returnurl' => env('APP_URL') . '/vnpay-return',
];
