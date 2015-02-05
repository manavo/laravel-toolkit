<?php

return [

    'assets' => [
        'css' => [
            'packages/manavo/laravel-toolkit/css/libs/bootstrap.min.css',
        ],
        'js'  => [
            'packages/manavo/laravel-toolkit/js/libs/jquery-1.11.1.min.js',
            'packages/manavo/laravel-toolkit/js/libs/bootstrap.min.js',
        ],
    ],

    'settings' => [
        'plans' => [
            [
                'id' => 'planid',
                'name' => 'Plan Name',
                'featured' => false,
                'price' => 9,
                'items' => [
                    'Details',
                ],
            ],
        ],
    ],

    'stripe' => [
        'keys' => [
            'secret' => '',
            'publishable' => '',
        ]
    ],

];
