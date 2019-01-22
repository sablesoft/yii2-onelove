<?php

return [
    'user' => [
        'enableAutoLogin' => true,
        'identityCookie' => [
            'name'     => '_oneloveId',
            'domain'   => ".$domainName",
            'path'     => '/',
            'httpOnly' => true
        ]
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
                        'ActiveForm' => '\yii\widgets\ActiveForm'
                    ]
                ]
            ]
        ]
    ]
];