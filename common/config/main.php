<?php
return [
    'name'       => 'OneLove',
    'language'   => 'ru-RU',
    'layout' => 'main.tpl',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset'
    ],
    'vendorPath' => dirname( dirname(__DIR__ ) ) . '/vendor',
    'components' => require( __DIR__ . '/components.php' ),
    'modules'    => require( __DIR__ . '/modules.php' )
];
