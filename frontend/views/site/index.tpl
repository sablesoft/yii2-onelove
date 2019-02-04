{* @var $ask Ask *}
{* @var $party Party *}
{* @var array $failModal *}
{* @var array $successModal *}
{use class='common\models\Helper'}
<div id="landing">
    {registerCss}
    .FAQ ul>li {
        list-style-image: url('/landing/img/heart-ico15x15.png');
    }
    {/registerCss}
    <main>
    {$sections = Helper::getSettings('section', true )}
        {include '@frontend/views/site/landing/registration.tpl'}
        {include '@frontend/views/site/landing/about.tpl'}
        {include '@frontend/views/site/landing/reason.tpl'}
    {if !empty( $sections['gallery'] )}
        {include '@frontend/views/site/landing/gallery.tpl'}
    {/if}
        {include '@frontend/views/site/landing/statistics.tpl'}
    {if !empty( $sections['comments'] )}
        {include '@frontend/views/site/landing/comments.tpl'}
    {/if}
        {include '@frontend/views/site/landing/faq.tpl'}
    </main>
    {include '@frontend/views/site/landing/footer.tpl'}
</div>
{$party->map}
{use class='yii\helpers\Html'}

{* Success Ask Modal: *}
{$header = $successModal['header']}
{Modal options=['id'=> $successModal['id'] ] header="<h3 class='text-center'>$header</h3>"}
    <div class="row">
        <p class="text-center">{$successModal['message']}</p>
    </div>
    <div class="row">
        <div class="col-sm-offset-5 col-sm-7">
            {Html::button(
                Yii::t('app/frontend','Success'),
                ['data-dismiss' => 'modal', 'class' => 'btn btn-success btn-lg']
            )}
        </div>
    </div>
{/Modal}

{* Fail Ask Modal: *}
{$header = $failModal['header']}
{Modal options=['id'=>$failModal['id']] header="<h2 class='text-center'>$header</h2>"}
    <div class="row">
        <p class="text-center">{$failModal['message']}</p>
    </div>
    <div class="row">
        <div class="col-sm-offset-5 col-sm-7">
            {Html::button(
                Yii::t('app/frontend','Fail'),
                ['data-dismiss' => 'modal', 'class' => 'btn btn-danger btn-lg']
            )}
        </div>
    </div>
{/Modal}