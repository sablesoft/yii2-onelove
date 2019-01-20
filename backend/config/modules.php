<?php

return [
    'user' => [
        'class' => 'dektrium\user\Module',
        // following line will restrict access to profile, recovery,
        // registration and settings controllers from backend
        'as backend' => 'dektrium\user\filters\BackendFilter',
        'enableRegistration' => false
    ]
];