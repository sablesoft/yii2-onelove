{use class='frontend\assets\AppAsset'}
{use class='yii\helpers\Html'}
{use class='common\widgets\Alert'}
{use class='common\models\Helper'}
{use class='yii\helpers\Url'}

{AppAsset::register($this)|void}
{$this->beginPage()}
<!DOCTYPE html>
<html lang="{Yii::$app->language}">
<head>
    <meta charset="{Yii::$app->charset}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {Html::csrfMetaTags()}
    <title>{$this->title}</title>
    {$this->head()}
    {registerJsFile url='/js/yandex.metrika.js' position='POS_END'}
    <noscript><div><img src="https://mc.yandex.ru/watch/51928937"
                        style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#cd6666">
    <meta name="msapplication-TileColor" content="#9f00a7">
    <meta name="theme-color" content="#cd6666">
</head>
<body id="{Helper::pageId()}">
{$this->beginBody()}

{include '@frontend/views/layouts/landing/navbar.tpl'}
{$content}

{include '@frontend/views/layouts/footer.tpl'}

{$this->endBody()}
</body>
</html>
{$this->endPage()}
