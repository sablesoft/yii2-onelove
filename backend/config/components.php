<?php

return [
    'request' => [
        'csrfParam' => '_csrf-backend'
    ],
    'log' => [
        'traceLevel' => YII_DEBUG ? 3 : 0,
        'targets' => [
            [
                'class' => 'yii\log\FileTarget',
                'levels' => ['error', 'warning']
            ]
        ]
    ],
    'errorHandler' => [
        'errorAction' => 'site/error'
    ],
    'urlManager' => [
        'rules' => [
            '/' => '/site/index',
            '/login' => '/user/security/login',
            '/logout' => '/user/security/logout'
        ]
    ]
];