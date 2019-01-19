<?php
return [
    'name'       => 'OneLove',
    'language'   => 'ru-RU',
    'layout' => 'main.tpl',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset'
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false
        ],
        'assetManager' => [
            'linkAssets' => true
        ],
        'vueManager'   => [
            'class'      => 'sablerom\vue\VueManager',
            'delimiters' => [ '[[', ']]' ]  // specify custom for smarty
        ],
        'view' => [
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
    ]
];
