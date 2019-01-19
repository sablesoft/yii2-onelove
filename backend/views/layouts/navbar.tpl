{use class='backend\widgets\Nav'}
{use class='yii\bootstrap\NavBar'}
{NavBar::begin([
    'brandLabel' => Yii::$app->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top'
    ]
])|void}
{Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => Nav::menuItems()
])}
{NavBar::end()|void}