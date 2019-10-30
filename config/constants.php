<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Order Constants
    |--------------------------------------------------------------------------
    |
    | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
    | to accept any value.
    |
    */
    'order' => [
        'base_factor' => env('ORDER_BASE_FACTOR', 0.2),
        'age_discount' => env('ORDER_AGE_DISCOUNT', 0.03),
        'condition_factor' => env('ORDER_CONDITION_FACTOR', 10),

        'commission' => env('ORDER_COMMISSION', 0.2),
        'delivery' => env('ORDER_DELIVERY', 500),
        'dry_cleaning' => env('ORDER_DRY_CLEANING', 500),
        'insurance' => env('ORDER_INSURANCE', 0.025),
        'promo_discount' => env('ORDER_PROMO_DISCOUNT', 0),
    ]

];
