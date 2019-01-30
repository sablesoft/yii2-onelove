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
                    {$keys = Helper::getSettings('keys')}
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
            {if $party->id}
                <p>Ближайший вечер:<span>{$party->timeLabel}</span></p>
            {/if}
                {$place = $party->currentPlace}
            {if !is_null( $place )}
                <p>Место проведения:
                    <br><span>{$place->name}</span>
                    <br><span>({$place->address})</span>
                </p>
            {/if}
            </div>
        </article>
    </div>
</section>
