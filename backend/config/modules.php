<?php

return [
    'user' => [
        'class' => 'dektrium\user\Module',
        // following line will restrict access to profile, recovery,
        // registration and settings controllers from backend
        'as backend' => [
            'class' => 'dektrium\user\filters\BackendFilter',
            'controllers' => [ 'recovery', 'registration', 'settings']
        ],
        'enableRegistration' => false
    ],
    'gridview' =>  [
        'class' => '\kartik\grid\Module'
    ]
];