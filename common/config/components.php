<?php

return [
    'log' => [
        'flushInterval' => 1,
        'targets' => [
            'error' => [
                'class' => 'yii\log\FileTarget',
                'levels' => ['error'],
                'logFile' => '@common/../logs/error.log',
                'except' => [
                    'yii\web\HttpException:403',
                    'yii\web\HttpException:404'
                ],
                'exportInterval' => 1
            ],
            'warning' => [
                'class' => 'yii\log\FileTarget',
                'levels' => ['warning'],
                'logFile' => '@common/../logs/warning.log',
                'exportInterval' => 1
            ],
            'email' => [
                'class' => 'yii\log\EmailTarget',
                'levels' => ['error'],
                'message' => [
                    'from'      => ['dev@onelove.by'],
                    'to'        => ['admin@onelove.by'],
                    'subject'   => 'Errors on OneLove'
                ],
                'except' => [
                    'yii\web\HttpException:403',
                    'yii\web\HttpException:404'
                ],
                'exportInterval' => 1
            ]
        ]
    ],
    'user' => [
        'enableAutoLogin' => true,
        'identityCookie' => [
            'name'     => '_oneloveId',
            'domain'   => ".$domain",
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
    'imagemanager' => [
        'class' => 'noam148\imagemanager\components\ImageManagerGetPath',
        //set media path (outside the web folder is possible)
        'mediaPath' => '../../media',
        //path relative web folder. In case of multiple environments (frontend, backend) add more paths
        'cachePath' =>  ['assets/media'],
        //use filename (seo friendly) for resized images else use a hash
        'useFilename' => true,
        //show full url (for example in case of a API)
        'absoluteUrl' => false,
        'databaseComponent' => 'db' // The used database component by the image manager, this defaults to the Yii::$app->db component
    ],
    'session' => [
        'name' => 'ONELOVE_SESSION',
        'cookieParams'  => [
            'httpOnly'  => true,
            'path'      => '/',
            'domain'    => ".$domain"
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
        'showScriptName' => false,
        'rules' => [
            '/imagemanager' => '/media',
            '/imagemanager/<controller>' => '/media/<controller>',
            '/imagemanager/<controller>/<action>' => '/media/<controller>/<action>',
        ]
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