<?php

return [
    /*
    |--------------------------------------------------------------------------
    | VNPay Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for VNPay payment gateway integration
    |
    */

    'tmn_code' => env('VNPAY_TMN_CODE', 'W2XA0CQK'),
    'hash_secret' => env('VNPAY_HASH_SECRET', 'QJTU6QPBAR4ABZDAF84TO46G4RSQAMYX'),
    'payment_url' => env('VNPAY_PAYMENT_URL', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html'),
    'query_url' => env('VNPAY_QUERY_URL', 'https://sandbox.vnpayment.vn/merchant_webapi/api/transaction'),
    'refund_url' => env('VNPAY_REFUND_URL', 'https://sandbox.vnpayment.vn/merchant_webapi/api/transaction/refund'),
    
    // In production, change sandbox to live URLs:
    // 'payment_url' => 'https://payment.vnpayment.vn/paygate',
    // 'query_url' => 'https://api.vnpayment.vn/merchant_webapi/api/transaction',
    // 'refund_url' => 'https://api.vnpayment.vn/merchant_webapi/api/transaction/refund',

    'app_url' => env('APP_URL', 'http://localhost'),
];
