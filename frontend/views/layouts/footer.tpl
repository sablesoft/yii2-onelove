{use class='common\models\Helper'}
{$owner = Helper::getParams('owner')}
<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; {Yii::t('app', Yii::$app->name )} {date('Y')}</p>
        <p class="pull-right">{$owner}</p>
    </div>
</footer>