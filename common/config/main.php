<?php
return [
    'name'       => 'OneLove',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset'
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache'
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
