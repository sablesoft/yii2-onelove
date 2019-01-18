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
</head>
<body id="{Helper::pageId()}">
{$this->beginBody()}

<div class="wrap">
    {include '@frontend/views/layouts/navbar.tpl'}
    <div id="main-container" class="container">
        {include '@frontend/views/layouts/breadcrumbs.tpl'}
        {Alert::widget()}
        {$content}
    </div>
</div>

{include '@frontend/views/layouts/footer.tpl'}

{$this->endBody()}
</body>
</html>
{$this->endPage()}
