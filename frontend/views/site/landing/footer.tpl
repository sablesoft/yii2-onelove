{use class='common\models\Helper'}
{$place = $party->place}
{$price = $party->getPrice( true )}
<footer>
    {* Place and price: *}
    <div class="landing-wrapper">


        <article class="contact">
            <div class="wrapper">
                <h2>Место проведения и стоимость</h2>
                <div class="image"><img src="landing/img/article-address.png" alt="{$place->name}"></div>
                <div class="address">
                    <p class="address-title"><b>{$place->name}</b></p>
                    <address>({$place->address})</address>
                    {if $party->timeLabel}
                    <strong>{$party->timeLabel}</strong>
                    {/if}
                    <p><strong>Стоимость участия - <span>{$price->baseLabel}</span></strong></p>
                    <p><strong>Вы пришли не один, то для Вас и ваших друзей стоимость - <span>{$price->companyLabel}</span></strong></p>
                    <p><strong>А если Вы решили прийти к нам еще раз - </strong><span><b>{$price->repeatLabel}</b></span></p>
                </div>
            </div>
        </article>

        <article class="registration-description">
            <h3><span>Приходите!</span><br><span>Удачное свидание неизбежно!</span></h3>

            {$formId = 'registration-form-footer'}
            {$rightColumnClass = 'col-sm-4'}
            {$leftColumnClass = 'col-sm-6 col-sm-offset-2'}
            {include '@frontend/views/site/landing/form.tpl'}

            <div class="row">
                <div class="col-sm-10 col-sm-offset-2">
                    <div class="registration-info">
                        {if $party->timeLabel}
                        <p>Ближайший вечер:<span>{$party->timeLabel}</span></p>
                        {/if}
                    </div>
                </div>
            </div>

        </article>
        <p class="quote"><b>«Кто ищет, тот всегда найдет!»</b></p>
    </div>

    <div class="background-photo">
        <i class="fas fa-times close"></i>
        <img src="landing/img/photo/photo1.jpg" alt="Photo">
    </div>

    {* Ask Form: *}
    <article class="registration-description-bottom form-modal">
        <i class="fas fa-times close"></i>
        <h2>Клуб знакомств <span>OneLove</span></h2>
        {$formId = 'registration-form-bottom'}
        {$rightColumnClass = 'col-sm-12'}
        {$leftColumnClass = 'col-sm-12'}
        {include '@frontend/views/site/landing/form.tpl'}
        <div class="registration-info">
            {if $party->timeLabel}
            <p>Ближайший вечер:<span>{$party->timeLabel}</span></p>
            {/if}
            {if $party->timeLabel}
            <p>Придет:<span>{$party->membersLabel}</span></p>
            {/if}
        </div>
    </article>

    {* Call Form: *}
    {include '@frontend/views/site/landing/call.tpl'}

</footer>
