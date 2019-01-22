<?php

return [
    'rbac' => [
        'class' => 'dektrium\rbac\RbacWebModule'
    ],
    'user' => [
        'class' => 'dektrium\user\Module',
        'enableConfirmation' => false,
        'admins' => ['admin'],
        'modelMap' => [
            'User' => 'common\models\User'
        ]
        // you will configure your module inside this file
        // or if need different configuration for frontend and backend you may
        // configure in needed configs
    ]
];