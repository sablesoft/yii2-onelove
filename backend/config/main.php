<?php

return [
    'id' => 'back',
    'name' => 'OneLove : CRM',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => require( __DIR__ . '/modules.php' ),
    'components' => require( __DIR__ . '/components.php' ),
    // backend params:
    'params' => yii\helpers\ArrayHelper::merge(
        require __DIR__ . '/../../common/config/params.php',
        require __DIR__ . '/../../common/config/params-local.php',
        require __DIR__ . '/params.php',
        require __DIR__ . '/params-local.php'
    )
];
