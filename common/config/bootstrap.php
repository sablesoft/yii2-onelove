<?php
use yii\base\Event;
use yii\web\Controller;

Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');

$hostName = !empty( $_SERVER['HTTP_HOST'] )?
    $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];

$domainName = implode('.', array_slice( explode('.', $hostName ), -2 ) );

// access handler:
Event::on( Controller::class,
    Controller::EVENT_BEFORE_ACTION,
    ['common\observer\ActionAccess', 'beforeAction']
);
