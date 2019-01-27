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
<body>
{$this->beginBody()}

<div class="wrap">
    <div id="main-container" class="container">
        {$content}
    </div>
</div>

{include '@backend/views/layouts/footer.tpl'}

{$this->endBody()}
</body>
</html>
{$this->endPage()}
