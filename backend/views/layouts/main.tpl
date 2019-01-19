{use class='backend\assets\AppAsset'}
{use class='common\widgets\Alert'}
{use class='common\models\Helper'}
{use class='yii\helpers\Html'}
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
</head>
<body id="{Helper::pageId()}">
{$this->beginBody()}

<div class="wrap">
    {include '@backend/views/layouts/navbar.tpl'}
    <div id="main-container" class="container">
        {include '@common/views/layouts/breadcrumbs.tpl'}
        {Alert::widget()}
        {$content}
    </div>
</div>

{include '@backend/views/layouts/footer.tpl'}

{$this->endBody()}
</body>
</html>
{$this->endPage()}
