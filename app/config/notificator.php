<?php

return [
    /**
     * Max amount of stored message for user.
     * Quantity is infinity if zero set.
     */
    'max' => env('NOTIFICATOR_MAX', 0),
    /**
     * Max amount of tries
     */
    'attempts' => env('NOTIFICATOR_ATTEMPTS', 3),
    /**
     * Delay after set amount of attempts
     */
    'delay' => env('NOTIFICATOR_DELAY', 30),
    'recipients' => [
        'goranton98@gmail.com',
    ]
];
