{* @var $ask Ask *}
{* @var $party Party *}
{use class='common\models\Helper'}
<section class="registration">
    <div class="landing-wrapper">
        <img src="landing/img/sec1art1.png" alt="">
        <h1>Клуб знакомств <span>OneLove</span></h1>
        <article class="registration-description">
            <div class="registration-title">
                <h2 class="title">ключ к вашему совместному будущему</h2>
                <ul>
                    {$keys = Helper::getParams('keys')}
                    {foreach from=$keys item=item}
                        <li>{$item['text']}</li>
                    {/foreach}
                </ul>
            </div>

            {$formId = 'registration-form'}
            {$rightColumnClass = 'col-sm-5'}
            {$leftColumnClass = 'col-sm-6 col-sm-offset-1'}
            {include '@frontend/views/site/landing/form.tpl'}

            <div class="registration-info">
                <p>Ближайший вечер:<span>{$party->timeLabel}</span></p>
                {*todo - groups setting:*}
                <p>Возрастные группы:<br><span>от 22 до 34</span><br><span class="age-old">от 35 и старше</span></p>
            </div>
        </article>
    </div>
</section>
