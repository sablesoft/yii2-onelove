<?php

return [
    'log' => [
        'flushInterval' => 1,
        'targets' => [
            'error' => [
                'class' => 'yii\log\FileTarget',
                'levels' => ['error'],
                'logFile' => '@common/../logs/error.log',
                'exportInterval' => 1
            ],
            'warning' => [
                'class' => 'yii\log\FileTarget',
                'levels' => ['warning'],
                'logFile' => '@common/../logs/warning.log',
                'exportInterval' => 1,
            ],
            'email' => [
                'class' => 'yii\log\EmailTarget',
                'levels' => ['error'],
                'message' => [
                    'from' => ['noreply@onelove.by'],
                    'to' => ['sable.lair@gmail.com'],
                    'subject' => 'Errors on OneLove',
                ],
                'exportInterval' => 1
            ]
        ]
    ],
    'user' => [
        'enableAutoLogin' => true,
        'identityCookie' => [
            'name'     => '_oneloveId',
            'domain'   => ".$domainName",
            'path'     => '/',
            'httpOnly' => true
        ]
    ],
    'mailer' => [
        'class' => 'yii\swiftmailer\Mailer',
        'messageConfig' => [
            'charset' => 'UTF-8',
            'from' => [ 'noreply@onelove.by' => 'OneLove CRM']
        ],
        'viewPath' => '@common/mail',
        'htmlLayout' => '@common/mail/layouts/backend.tpl',
        'enableSwiftMailerLogging' => true
    ],
    'session' => [
        'name' => 'ONELOVE_SESSION',
        'cookieParams'  => [
            'httpOnly'  => true,
            'path'      => '/',
            'domain'    => ".$domainName"
        ]
    ],
    'cache' => [
        'class' => 'yii\caching\FileCache'
    ],
    'i18n' => [
        'translations' => [
            'app*' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@common/messages',
                'sourceLanguage' => 'en-US',
            ],
            'yii' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'basePath' => '@common/messages'
            ],
        ]
    ],
    'formatter' => [
        'locale' => 'ru_RU',
        'dateFormat' => 'php:d.m.y',
        'timeFormat' => 'php:H:i',
        'defaultTimeZone' => 'Europe/Minsk',
        'datetimeFormat' => 'php:d mm, y - H:i',
        'decimalSeparator' => ',',
        'thousandSeparator' => ' ',
        'currencyCode' => 'BYN',
        'numberFormatterOptions' => [
            NumberFormatter::MIN_FRACTION_DIGITS => 0,
            NumberFormatter::MAX_FRACTION_DIGITS => 0,
            NumberFormatter::FRACTION_DIGITS => 0
        ],
        'numberFormatterSymbols' => [
            NumberFormatter::CURRENCY_SYMBOL => 'руб.'
        ]
    ],
    'urlManager' => [
        'enablePrettyUrl' => true,
        'showScriptName' => false
    ],
    'assetManager' => [
        'linkAssets' => true
    ],
    'vueManager'   => [
        'class'      => 'sablesoft\vue\VueManager',
        'delimiters' => [ '[[', ']]' ]  // specify custom for smarty
    ],
    'view' => [
        'theme' => [
            'pathMap' => [
                '@dektrium/user/views' => '@common/views/user'
            ]
        ],
        'renderers' => [
            'tpl' => [
                'class' => 'yii\smarty\ViewRenderer',
                //'cachePath' => '@runtime/Smarty/cache',
                'widgets' => [
                    'blocks' => [
                        'Modal'         => '\yii\bootstrap\Modal',
                        'ActiveForm'    => '\yii\widgets\ActiveForm'
                    ]
                ]
            ]
        ]
    ]
];