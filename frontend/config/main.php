<?php

return [
    'id' => 'front',
    'name' => 'Клуб знакомств OneLove', // todo settings
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'deviceDetect'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => require( __DIR__ . '/components.php' ),
    'modules' => require( __DIR__ . '/modules.php' ),
    'params' => yii\helpers\ArrayHelper::merge(
        require __DIR__ . '/../../common/config/params.php',
        require __DIR__ . '/../../common/config/params-local.php',
        require __DIR__ . '/params.php',
        require __DIR__ . '/params-local.php'
    )
];
