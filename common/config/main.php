<?php
return [
    'name'       => 'OneLove',
    'language'   => 'ru-RU',
    'timeZone'   => 'Europe/Minsk',
    'layout' => 'main.tpl',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset'
    ],
    'bootstrap' => ['log'],
    'vendorPath' => dirname( dirname(__DIR__ ) ) . '/vendor',
    'components' => require( __DIR__ . '/components.php' ),
    'modules'    => require( __DIR__ . '/modules.php' )
];
